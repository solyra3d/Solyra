<?php
/**
 * SOLYRA - Upload Handler
 * Upload seguro com validação de MIME type, renomeação automática e compressão
 */

class Upload
{
    private static array $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/jpg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    private static int $maxFileSize = 5242880; // 5MB padrão

    /**
     * Upload de arquivo único
     */
    public static function file(array $file, string $directory, ?int $maxSize = null): array
    {
        $maxSize = $maxSize ?? self::$maxFileSize;

        // Validações
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => self::getUploadError($file['error'])];
        }

        if ($file['size'] > $maxSize) {
            return ['success' => false, 'error' => 'Arquivo excede o tamanho máximo permitido.'];
        }

        // Validar MIME type real
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!isset(self::$allowedTypes[$mimeType])) {
            return ['success' => false, 'error' => 'Tipo de arquivo não permitido. Use JPG, PNG ou WEBP.'];
        }

        // Gerar nome único
        $extension = self::$allowedTypes[$mimeType];
        $filename = self::generateFilename($extension);

        // Criar diretório se não existir
        $uploadPath = ROOT_PATH . '/public/uploads/' . trim($directory, '/');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $fullPath = $uploadPath . '/' . $filename;

        // Mover arquivo
        if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
            return ['success' => false, 'error' => 'Erro ao salvar arquivo.'];
        }

        // Comprimir imagem
        self::compressImage($fullPath, $mimeType);

        $relativePath = 'uploads/' . trim($directory, '/') . '/' . $filename;

        return [
            'success' => true,
            'filename' => $filename,
            'path' => $relativePath,
            'full_path' => $fullPath,
            'mime_type' => $mimeType,
            'size' => $file['size'],
        ];
    }

    /**
     * Upload múltiplo
     */
    public static function multiple(array $files, string $directory, ?int $maxSize = null): array
    {
        $results = [];
        $fileCount = count($files['name']);

        for ($i = 0; $i < $fileCount; $i++) {
            $file = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i],
            ];

            if ($file['error'] === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            $results[] = self::file($file, $directory, $maxSize);
        }

        return $results;
    }

    /**
     * Deletar arquivo
     */
    public static function deleteFile(string $relativePath): bool
    {
        $fullPath = ROOT_PATH . '/public/' . $relativePath;
        
        if (file_exists($fullPath) && is_file($fullPath)) {
            return unlink($fullPath);
        }
        
        return false;
    }

    /**
     * Comprimir imagem
     */
    private static function compressImage(string $path, string $mimeType, int $quality = 82): void
    {
        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($path);
                if ($image) {
                    imagejpeg($image, $path, $quality);
                    imagedestroy($image);
                }
                break;

            case 'image/png':
                $image = imagecreatefrompng($path);
                if ($image) {
                    imagepng($image, $path, 8);
                    imagedestroy($image);
                }
                break;

            case 'image/webp':
                $image = imagecreatefromwebp($path);
                if ($image) {
                    imagewebp($image, $path, $quality);
                    imagedestroy($image);
                }
                break;
        }
    }

    /**
     * Gerar nome de arquivo único
     */
    private static function generateFilename(string $extension): string
    {
        return date('Y-m-d') . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
    }

    /**
     * Traduzir erro de upload
     */
    private static function getUploadError(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE => 'Arquivo excede o limite do servidor.',
            UPLOAD_ERR_FORM_SIZE => 'Arquivo excede o limite do formulário.',
            UPLOAD_ERR_PARTIAL => 'Upload incompleto.',
            UPLOAD_ERR_NO_FILE => 'Nenhum arquivo enviado.',
            UPLOAD_ERR_NO_TMP_DIR => 'Pasta temporária não encontrada.',
            UPLOAD_ERR_CANT_WRITE => 'Falha ao gravar no disco.',
            default => 'Erro desconhecido no upload.',
        };
    }
}
