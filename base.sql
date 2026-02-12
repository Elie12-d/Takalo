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
    estimated_value DOUBLE,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
CREATE TABLE exchanges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user1_id INT NOT NULL, 
    user2_id INT NOT NULL, 
    object1_id INT NOT NULL,
    object2_id INT NOT NULL,
    status VARCHAR(100) DEFAULT 'pending',
    proposed_at DATETIME,
    responded_at DATETIME,
    completed_at DATETIME,
    FOREIGN KEY (user1_id) REFERENCES users(id),
    FOREIGN KEY (user2_id) REFERENCES users(id),
    FOREIGN KEY (object1_id) REFERENCES objects(id),
    FOREIGN KEY (object2_id) REFERENCES objects(id),
    CHECK (user1_id != user2_id), 
    CHECK (object1_id != object2_id)
);
CREATE TABLE photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    objet_id INT NOT NULL,
    chemin VARCHAR(255) NOT NULL,
    ordre INT DEFAULT 0,
    FOREIGN KEY (objet_id) REFERENCES objects(id)
);
CREATE TABLE historique_propriete (
    id INT AUTO_INCREMENT PRIMARY KEY,
    objet_id INT NOT NULL,
    utilisateur_id INT NOT NULL,
    date_debut DATETIME NOT NULL,
    date_fin DATETIME DEFAULT NULL,
    echange_id INT NULL,
    FOREIGN KEY (objet_id) REFERENCES objects(id),
    FOREIGN KEY (utilisateur_id) REFERENCES users(id),
    FOREIGN KEY (echange_id) REFERENCES exchanges(id)
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
('Electronique', 'Appareils electroniques, smartphones, ordinateurs, etc.', 'active', '2024-01-15'),
('Vehicules', 'Voitures, motos, velos et autres moyens de transport', 'active', '2024-01-16'),
('Immobilier', 'Appartements, maisons, terrains a vendre ou louer', 'active', '2024-01-17'),
('Mode Accessoires', 'Vetements, chaussures, bijoux, accessoires', 'active', '2024-01-18'),
('Maison Jardin', 'Meubles, electromenager, decoration, outils de jardin', 'active', '2024-01-19'),
('Emploi', 'Offres d emploi, services professionnels', 'active', '2024-01-20'),
('Loisirs Sport', 'Instruments de musique, equipement sportif, jeux video', 'active', '2024-01-21'),
('Animaux', 'Chiens, chats, oiseaux, accessoires pour animaux', 'active', '2024-01-22'),
('Materiel Professionnel', 'Outils professionnels, machines, equipement industriel', 'active', '2024-01-23'),
('Services', 'Services divers : cours, reparations, transport, etc.', 'active', '2024-01-24');

-- Insérer des objets/annonces réalistes
INSERT INTO objects (user_id, name, description, category_id, published_at, estimated_value) VALUES
(1, 'iPhone 13 Pro 256GB', 'iPhone 13 Pro en excellent etat, achete il y a 6 mois. Boitier, chargeur et ecouteurs d origine inclus. Ecran intact, batterie a 96%.', 1, '2024-02-01', 699.00),
(2, 'Peugeot 208 GT Line 2020', 'Peugeot 208 GT Line 2020, 45 000 km, diesel, boite manuelle. Premier proprietaire, entretien a jour chez concessionnaire. Pas de travaux a prevoir.', 2, '2024-02-02', 15900.00),
(3, 'Appartement F3 centre ville', 'Bel appartement de 65m² au 2eme etage avec ascenseur. Sejour, deux chambres, cuisine equipee, salle de bain. Proche transports et commerces.', 3, '2024-02-03', 185000.00),
(4, 'Canape convertible 3 places', 'Canape convertible en tissu gris anthracite, tres bon etat. Dimensions ouvert : 200x140cm. Livraison possible dans le secteur.', 5, '2024-02-04', 350.00),
(1, 'PlayStation 5 + 2 manettes', 'PS5 edition standard avec 2 manettes DualSense, cables HDMI et secteur. Inclut les jeux Spider-Man 2 et FIFA 24. Parfait etat.', 7, '2024-02-05', 450.00),
(5, 'Cours de piano debutant', 'Donne cours de piano pour debutants. 15 ans d experience, methode adaptee a chaque eleve. Disponible en semaine et week-end.', 10, '2024-02-06', 25.00),
(6, 'MacBook Air M2 2023', 'MacBook Air 13 pouces M2, 512GB SSD, 16GB RAM. Presque neuf, achete il y a 3 mois. Garantie Apple jusqu a decembre 2024.', 1, '2024-02-07', 1299.00),
(7, 'Velo de route Trek Domane', 'Velo de route Trek Domane AL 3, taille 56, cadre aluminium. Equipe Shimano Sora, pneus neufs. Tres bon etat general.', 2, '2024-02-08', 850.00),
(8, 'Service de nettoyage maison', 'Service professionnel de nettoyage residentiel. Deplacement gratuit, produits ecologiques fournis. References sur demande.', 10, '2024-02-09', 35.00),
(2, 'Machine a cafe Delonghi', 'Machine a cafe Delonghi Magnifica S, broyeur integre. Fonctionne parfaitement, nettoyee regulierement. Ideale pour les amateurs de cafe.', 5, '2024-02-10', 280.00),
(3, 'Costume Hugo Boss', 'Costume trois pieces Hugo Boss, taille 52R. Porte une seule fois pour un mariage. Coupe moderne, couleur anthracite.', 4, '2024-02-11', 390.00),
(4, 'Golden Retriever a adopter', 'Chiot Golden Retriever de 3 mois, vaccine et vermifuge. Papiers LOF. Tres sociable, ideal pour famille avec enfants.', 8, '2024-02-12', 600.00),
(5, 'Poste developpeur web', 'Recherche developpeur PHP/Symfony avec 3 ans d experience. CDI, teletravail partiel possible. Salaire selon profil + avantages.', 6, '2024-02-13', 45000.00),
(6, 'Guitare acoustique Yamaha', 'Guitare acoustique Yamaha FG800, modele dreadnought. Bon etat, accord stable. Ideale pour debutant ou confirme.', 7, '2024-02-14', 120.00),
(7, 'Table basse en chene massif', 'Table basse artisanale en chene massif, dimensions 120x60x45cm. Fabrication francaise, finition huilee. Tres solide.', 5, '2024-02-15', 210.00),
(8, 'Appareil photo Canon EOS R', 'Canon EOS R avec objectif 24-105mm f/4. Boitier comme neuf, moins de 5000 declenchements. Accessoires inclus.', 1, '2024-02-16', 1890.00),
(1, 'Location garage 20m²', 'Garage ferme et securise de 20m². Acces facile, electricite disponible. Ideal stockage ou bricolage.', 3, '2024-02-17', 80.00),
(2, 'Montre Rolex Datejust', 'Rolex Datejust 36mm, reference 126234. Boitier acier/or, cadran bleu. Achetee en 2021, papiers et boite d origine.', 4, '2024-02-18', 6950.00),
(3, 'Tondeuse a gazon Honda', 'Tondeuse a gazon Honda HRG536, moteur essence. Largeur de coupe 53cm, bac de ramassage 70L. Tres bon etat.', 5, '2024-02-19', 390.00),
(4, 'Service traiteur evenements', 'Service traiteur pour mariages, anniversaires, seminaires. Menus personnalises, qualite professionnelle.', 10, '2024-02-20', 45.00);

-- Ajouter quelques objets supplementaires pour plus de variete
INSERT INTO objects (user_id, name, description, category_id, published_at, estimated_value) VALUES
(5, 'Bureau ergonomique reglable', 'Bureau electrique reglable en hauteur, plateau 160x80cm. Parfait pour teletravail ou gaming. Couleur chene/noir.', 5, '2024-02-21', 320.00),
(6, 'Cours particuliers de maths', 'Professeur certifie donne cours de mathematiques tous niveaux jusqu a la terminale. Methode pedagogique eprouvee.', 10, '2024-02-22', 30.00),
(7, 'Set de ski complet', 'Set ski Rossignol + chaussures + batons, taille 170cm. Utilise deux saisons, excellent etat. Pointure chaussures : 42.', 7, '2024-02-23', 220.00),
(8, 'Lave linge Samsung 9kg', 'Lave-linge Samsung WW90T534AAW, capacite 9kg, classe A+++. Silencieux, nombreuses fonctions. Achete il y a 1 an.', 5, '2024-02-24', 450.00),
(1, 'Chaise de bureau gaming', 'Chaise gaming Secretlab Titan Evo 2022, tissu softweave. Confort exceptionnel, excellente maintien dorsal. Couleur charcoal.', 5, '2024-02-25', 380.00),
(2, 'Livres Harry Potter collection', 'Collection complete Harry Potter edition originale francaise. 7 volumes, bon etat general. Parfaite pour collectionneur.', 7, '2024-02-26', 150.00);