-- Modüller tablosu
CREATE TABLE IF NOT EXISTS modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE COMMENT 'Module identifier (desensitization, immune_deficiencies, etc.)',
    title VARCHAR(255) NOT NULL COMMENT 'Görünen başlık',
    description TEXT DEFAULT NULL,
    icon VARCHAR(50) DEFAULT NULL COMMENT 'Material icon name',
    route VARCHAR(255) NOT NULL COMMENT 'URL route',
    is_active BOOLEAN DEFAULT TRUE,
    is_public BOOLEAN DEFAULT FALSE COMMENT 'Login gerektirmiyor mu?',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_is_active (is_active),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- İçerik tablosu (Dashboard'daki son eklenenler vs. için)
CREATE TABLE IF NOT EXISTS content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    module_id INT DEFAULT NULL,
    content_type VARCHAR(50) NOT NULL COMMENT 'guide, protocol, calculator, article, etc.',
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT DEFAULT NULL,
    content_data JSON DEFAULT NULL COMMENT 'İçeriğe özel data',
    author_id INT DEFAULT NULL,
    is_published BOOLEAN DEFAULT TRUE,
    published_at TIMESTAMP NULL,
    views_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_content_type (content_type),
    INDEX idx_slug (slug),
    INDEX idx_published (is_published, published_at),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Modül seed data
INSERT INTO modules (name, title, description, icon, route, is_active, sort_order) VALUES
('home', 'Ana Sayfa', 'Dashboard ve genel bakış', 'home', '/dashboard', TRUE, 1),
('desensitization', 'İlaç Desensitizasyonu', 'İlaç alerjileri ve desensitizasyon protokolleri', 'vaccines', '/module/desensitization', TRUE, 2),
('immune_deficiencies', 'İmmün Yetmezlikler', 'Primer ve sekonder immün yetmezlik hastalıkları', 'bloodtype', '/module/immune-deficiencies', TRUE, 3),
('laboratory', 'Laboratuvar', 'Test sonuçları ve referans değerleri', 'science', '/module/laboratory', TRUE, 4),
('guides', 'Rehberler', 'Klinik rehberler ve protokoller', 'article', '/module/guides', TRUE, 5);
