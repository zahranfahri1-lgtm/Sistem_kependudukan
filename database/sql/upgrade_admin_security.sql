-- Import sekali pada database penduduk yang sudah terpasang.
ALTER TABLE admin ADD COLUMN must_change_password TINYINT(1) NOT NULL DEFAULT 0;
UPDATE admin SET must_change_password=1
WHERE username='admin' AND password='$2y$10$yE6ZpJg5m0xsAx.26pc4SugF7cBANt9cORtMb27RQHC6WcxfI2GVi';
