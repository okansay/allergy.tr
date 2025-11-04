-- Demo kullanıcılar
-- Şifre: password123 (hash'lenmiş hali)

INSERT INTO users (email, password, full_name, title, specialty, hospital, is_active, is_verified, email_verified_at) VALUES
('demo@allergy.tr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dr. Ece Kaya', 'Dr.', 'Alerji & İmmünoloji', 'İstanbul Tıp Fakültesi', TRUE, TRUE, NOW()),
('test@allergy.tr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Prof. Dr. Ahmet Yılmaz', 'Prof. Dr.', 'Alerji & İmmünoloji', 'Ankara Üniversitesi Tıp Fakültesi', TRUE, TRUE, NOW());

-- Demo content
INSERT INTO content (module_id, content_type, title, slug, description, is_published, published_at) VALUES
((SELECT id FROM modules WHERE name = 'guides'), 'guide', 'Yeni Ürtiker Tedavi Rehberi', 'yeni-urtiker-tedavi-rehberi', '2024 güncellenmiş ürtiker tedavi protokolü', TRUE, DATE_SUB(NOW(), INTERVAL 2 DAY)),
((SELECT id FROM modules WHERE name = 'immune_deficiencies'), 'protocol', 'SCID Tarama Protokolü Güncellemesi', 'scid-tarama-protokolu', 'Yenidoğan SCID tarama protokolü', TRUE, DATE_SUB(NOW(), INTERVAL 5 DAY)),
((SELECT id FROM modules WHERE name = 'desensitization'), 'protocol', 'Beta-Laktam Desensitizasyon Protokolü', 'beta-laktam-desensitizasyon', 'Penisilin ve beta-laktam antibiyotik desensitizasyonu', TRUE, DATE_SUB(NOW(), INTERVAL 10 DAY));
