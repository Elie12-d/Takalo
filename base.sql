DROP DATABASE IF EXISTS revision_final_s3;
CREATE DATABASE revision_final_s3;
use revision_final_s3;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description VARCHAR(255),
    status VARCHAR(255),
    created_at DATE
);
CREATE TABLE objects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(255),
    description TEXT,
    category_id INT,
    published_at DATE,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
CREATE TABLE exchanges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user1_id INT NOT NULL, 
    user2_id INT NOT NULL, 
    object1_id INT NOT NULL,
    object2_id INT NOT NULL,
    status VARCHAR(100) DEFAULT 'pending',
    proposed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    responded_at DATETIME,
    completed_at DATETIME,
    FOREIGN KEY (user1_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (user2_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (object1_id) REFERENCES objects(id) ON DELETE CASCADE,
    FOREIGN KEY (object2_id) REFERENCES objects(id) ON DELETE CASCADE,
    CHECK (user1_id != user2_id),  -- Un utilisateur ne peut pas s'echanger avec lui meme
    CHECK (object1_id != object2_id)  -- Les objets doivent etre differents
);
INSERT INTO users (name, email, password) VALUES
('Jean Dupont', 'jean.dupont@email.com', 'password123'),
('Marie Martin', 'marie.martin@email.com', 'marie2024'),
('Pierre Durand', 'pierre.durand@email.com', 'pierre123'),
('Sophie Bernard', 'sophie.bernard@email.com', 'sophie456'),
('Thomas Petit', 'thomas.petit@email.com', 'thomas789'),
('Laura Robert', 'laura.robert@email.com', 'laura000'),
('Marc Lefebvre', 'marc.lefebvre@email.com', 'marc2024'),
('Julie Moreau', 'julie.moreau@email.com', 'julie123');

INSERT INTO categories (name, description, status, created_at) VALUES
('Électronique', 'Appareils électroniques, smartphones, ordinateurs, etc.', 'active', '2024-01-15'),
('Véhicules', 'Voitures, motos, vélos et autres moyens de transport', 'active', '2024-01-16'),
('Immobilier', 'Appartements, maisons, terrains à vendre ou louer', 'active', '2024-01-17'),
('Mode & Accessoires', 'Vêtements, chaussures, bijoux, accessoires', 'active', '2024-01-18'),
('Maison & Jardin', 'Meubles, électroménager, décoration, outils de jardin', 'active', '2024-01-19'),
('Emploi', 'Offres d\'emploi, services professionnels', 'active', '2024-01-20'),
('Loisirs & Sport', 'Instruments de musique, équipement sportif, jeux vidéo', 'active', '2024-01-21'),
('Animaux', 'Chiens, chats, oiseaux, accessoires pour animaux', 'active', '2024-01-22'),
('Matériel Professionnel', 'Outils professionnels, machines, équipement industriel', 'active', '2024-01-23'),
('Services', 'Services divers : cours, réparations, transport, etc.', 'active', '2024-01-24');

-- Insérer des objets/annonces réalistes
INSERT INTO objects (user_id, name, description, category_id, published_at) VALUES
(1, 'iPhone 13 Pro 256GB', 'iPhone 13 Pro en excellent état, acheté il y a 6 mois. Boîtier, chargeur et écouteurs d\'origine inclus. Écran intact, batterie à 96%.', 1, '2024-02-01'),
(2, 'Peugeot 208 GT Line 2020', 'Peugeot 208 GT Line 2020, 45 000 km, diesel, boîte manuelle. Premier propriétaire, entretien à jour chez concessionnaire. Pas de travaux à prévoir.', 2, '2024-02-02'),
(3, 'Appartement F3 centre-ville', 'Bel appartement de 65m² au 2ème étage avec ascenseur. Séjour, deux chambres, cuisine équipée, salle de bain. Proche transports et commerces.', 3, '2024-02-03'),
(4, 'Canapé convertible 3 places', 'Canapé convertible en tissu gris anthracite, très bon état. Dimensions ouvert : 200x140cm. Livraison possible dans le secteur.', 5, '2024-02-04'),
(1, 'PlayStation 5 + 2 manettes', 'PS5 édition standard avec 2 manettes DualSense, câbles HDMI et secteur. Inclut les jeux Spider-Man 2 et FIFA 24. Parfait état.', 7, '2024-02-05'),
(5, 'Cours de piano débutant', 'Donne cours de piano pour débutants. 15 ans d\'expérience, méthode adaptée à chaque élève. Disponible en semaine et week-end.', 10, '2024-02-06'),
(6, 'MacBook Air M2 2023', 'MacBook Air 13 pouces M2, 512GB SSD, 16GB RAM. Presque neuf, acheté il y a 3 mois. Garantie Apple jusqu\'à décembre 2024.', 1, '2024-02-07'),
(7, 'Vélo de route Trek Domane', 'Vélo de route Trek Domane AL 3, taille 56, cadre aluminium. Équipé Shimano Sora, pneus neufs. Très bon état général.', 2, '2024-02-08'),
(8, 'Service de nettoyage maison', 'Service professionnel de nettoyage résidentiel. Déplacement gratuit, produits écologiques fournis. Références sur demande.', 10, '2024-02-09'),
(2, 'Machine à café Delonghi', 'Machine à café Delonghi Magnifica S, broyeur intégré. Fonctionne parfaitement, nettoyée régulièrement. Idéale pour les amateurs de café.', 5, '2024-02-10'),
(3, 'Costume Hugo Boss', 'Costume trois pièces Hugo Boss, taille 52R. Porté une seule fois pour un mariage. Coupe moderne, couleur anthracite.', 4, '2024-02-11'),
(4, 'Golden Retriever à adopter', 'Chiot Golden Retriever de 3 mois, vacciné et vermifugé. Papiers LOF. Très sociable, idéal pour famille avec enfants.', 8, '2024-02-12'),
(5, 'Poste développeur web', 'Recherche développeur PHP/Symfony avec 3 ans d\'expérience. CDI, télétravail partiel possible. Salaire selon profil + avantages.', 6, '2024-02-13'),
(6, 'Guitare acoustique Yamaha', 'Guitare acoustique Yamaha FG800, modèle dreadnought. Bon état, accord stable. Idéale pour débutant ou confirmé.', 7, '2024-02-14'),
(7, 'Table basse en chêne massif', 'Table basse artisanale en chêne massif, dimensions 120x60x45cm. Fabrication française, finition huilée. Très solide.', 5, '2024-02-15'),
(8, 'Appareil photo Canon EOS R', 'Canon EOS R avec objectif 24-105mm f/4. Boîtier comme neuf, moins de 5000 déclenchements. Accessoires inclus.', 1, '2024-02-16'),
(1, 'Location garage 20m²', 'Garage fermé et sécurisé de 20m². Accès facile, électricité disponible. Idéal stockage ou bricolage.', 3, '2024-02-17'),
(2, 'Montre Rolex Datejust', 'Rolex Datejust 36mm, référence 126234. Boîtier acier/or, cadran bleu. Achetée en 2021, papiers et boîte d\'origine.', 4, '2024-02-18'),
(3, 'Tondeuse à gazon Honda', 'Tondeuse à gazon Honda HRG536, moteur essence. Largeur de coupe 53cm, bac de ramassage 70L. Très bon état.', 5, '2024-02-19'),
(4, 'Service traiteur événements', 'Service traiteur pour mariages, anniversaires, séminaires. Menus personnalisés, qualité professionnelle.', 10, '2024-02-20');

-- Ajouter quelques objets supplémentaires pour plus de variété
INSERT INTO objects (user_id, name, description, category_id, published_at) VALUES
(5, 'Bureau ergonomique réglable', 'Bureau électrique réglable en hauteur, plateau 160x80cm. Parfait pour télétravail ou gaming. Couleur chêne/noir.', 5, '2024-02-21'),
(6, 'Cours particuliers de maths', 'Professeur certifié donne cours de mathématiques tous niveaux jusqu\'à la terminale. Méthode pédagogique éprouvée.', 10, '2024-02-22'),
(7, 'Set de ski complet', 'Set ski Rossignol + chaussures + bâtons, taille 170cm. Utilisé deux saisons, excellent état. Pointure chaussures : 42.', 7, '2024-02-23'),
(8, 'Lave-linge Samsung 9kg', 'Lave-linge Samsung WW90T534AAW, capacité 9kg, classe A+++. Silencieux, nombreuses fonctions. Acheté il y a 1 an.', 5, '2024-02-24'),
(1, 'Chaise de bureau gaming', 'Chaise gaming Secretlab Titan Evo 2022, tissu softweave. Confort exceptionnel, excellente maintien dorsal. Couleur charcoal.', 5, '2024-02-25'),
(2, 'Livres Harry Potter collection', 'Collection complète Harry Potter édition originale française. 7 volumes, bon état général. Parfaite pour collectionneur.', 7, '2024-02-26');