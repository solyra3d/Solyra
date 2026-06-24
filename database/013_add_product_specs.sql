ALTER TABLE products
  ADD COLUMN spec_includes      VARCHAR(500)  NULL AFTER video_path,
  ADD COLUMN spec_dimensions    VARCHAR(200)  NULL AFTER spec_includes,
  ADD COLUMN spec_colors        VARCHAR(300)  NULL AFTER spec_dimensions,
  ADD COLUMN spec_material      VARCHAR(200)  NULL AFTER spec_colors,
  ADD COLUMN spec_led           VARCHAR(200)  NULL AFTER spec_material,
  ADD COLUMN spec_production    VARCHAR(100)  NULL AFTER spec_led,
  ADD COLUMN spec_warranty      VARCHAR(200)  NULL AFTER spec_production;
