






CREATE TABLE temporary_housing (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    pet_type ENUM('dog', 'cat', 'bird') NOT NULL,
    pet_name VARCHAR(100) NOT NULL,
    pet_breed VARCHAR(100),
    pet_age VARCHAR(50) NOT NULL,
    health_status TEXT,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    reason TEXT NOT NULL,
    pet_picture VARCHAR(255) NOT NULL,
    approved TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(255),
    date_posted DATE,
    category VARCHAR(255),
    tags VARCHAR(255),
    image_url VARCHAR(255),
    is_featured TINYINT(1) DEFAULT 0,
    views INT DEFAULT 0
    
);

INSERT INTO posts (title, content, author, date_posted, category, tags, image_url, is_featured)
VALUES
('The Benefits of Pet Adoption', 'Adopting a pet saves lives...', 'John Doe', '2024-09-21', 'Pet Care', 'adoption, rescue', 'images/picpic.webp', 1),
('How to Care for Your New Puppy', 'Caring for a new puppy...', 'Jane Smith', '2024-09-20', 'Pet Care', 'puppy, care', 'images/picpic2.jpg', 0),
('Upcoming Shelter Events', 'Join us for our shelter event...', 'Shelter Team', '2024-09-18', 'Events', 'events, adoption', 'images/pipcpic3.jpg', 0);

CREATE TABLE  user_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    blog_post TEXT NOT NULL,
    picture VARCHAR(255), -- Column to store the image path
    date_submitted DATETIME DEFAULT CURRENT_TIMESTAMP 
);

ALTER TABLE user_posts 
ADD COLUMN is_approved TINYINT(1) DEFAULT 0;






CREATE TABLE pets1 (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    breed VARCHAR(255) NOT NULL,
    age VARCHAR(50) NOT NULL,
    location VARCHAR(255) NOT NULL,
    gender VARCHAR(255) NOT NULL,
    pet_size VARCHAR(255) NOT NULL,
    fee VARCHAR(255) NOT NULL,
    temp VARCHAR(255) NOT NULL,
    image_url VARCHAR(255) NOT NULL
);

INSERT INTO pets1 (name, breed, age, location, gender, pet_size, fee, temp, image_url)
VALUES
('Bella', 'Poodle', '3 years', 'Los Angeles', 'Male', 'Medium', '15k', 'Friendly', 'images/dogpod.png'),
('Max', 'Poodle', '2 years', 'New York', 'Male', 'Large', '25k', 'Energetic', 'images/poddle2.jpg'), 

('Chini', 'Exotic Shorthair', '6 month', 'San Francisco', 'Female', 'Medium', '22k', 'Calm', 'images/catExo.png'),
('Mini', 'Exotic Shorthair', '1 year', 'San Francisco', 'Male', 'Medium', '16k', 'Friendly', 'images/exo2.jpg'),

('Leo', 'Budgerigar', '8 month', 'Pakistan', 'Female', 'Small', '18k', 'Energetic', 'images/birdBud.png'),
('Tweety', 'Budgerigar', '1.5 years', 'Pakistan', 'Female', 'Small', '12k', 'Friendly', 'images/bud2.jpg'),

('Johny', 'Bichon Frisé ', '2 years', 'Finland', 'Male', 'Large', '30k', 'Friendly', 'images/dog2.png'),
('Tommy', 'Bichon Frisé ', '2 years', 'Finland', 'Male', 'Medium', '20k', 'Energetic', 'images/bic2.jpg'),

('Anny', 'Norwegian Forest cat', '1 year', 'Norwegian ', 'Female', 'Medium', '18k', 'Calm', 'images/catNor.png'),
('Peanut', 'Norwegian Forest cat', '2 years', 'Norwegian ', 'Male', 'Small', '25k', 'Friendly', 'images/nor2.jpg'),

('Lanny', 'Cockatiel', '1.5 years', 'India', 'Female', 'Medium', '10k', 'Friendly', 'images/birdCok.png'),
('Pinni', 'Cockatiel', '5 months', 'India', 'Female', 'Small', '20k', 'Calm', 'images/cock2.jpg');




CREATE TABLE contact_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_type ENUM('phone', 'email', 'facebook') NOT NULL,
    contact_value VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO contact_info (contact_type, contact_value)
VALUES
('phone', '0186166884'),
('email', 'sumaiyalima789@gmail.com'),
('facebook', 'https://www.facebook.com/sumaiya.lima.25'),
('phone', '01569108045'),
('email', 'msristy221447@bscse.uiu.ac.bd'),
('facebook', 'https://www.facebook.com/mahmudaakter.sristy'),
('phone', '01745531727'),
('email', 'mdalmahfuzchowdhury@gmail.com'),
('facebook', 'https://www.facebook.com/siam.mahfuz.7');

CREATE TABLE faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO faqs (question, answer) VALUES 
('How do I adopt a pet?', 'You can browse the pets available for adoption and submit an adoption request.'),
('What is the adoption fee?', 'The adoption fee varies depending on the pet. Please contact us for more details.'),
('How long does the adoption process take?', 'The adoption process typically takes between 2-5 days, depending on the pet and the application.'),
('Can I return a pet if it doesn’t fit in?', 'While we do our best to match pets with the right owners, we understand things happen. Please contact us for returns.'),
('Do you offer support after adoption?', 'Yes, we offer post-adoption support through our network of veterinarians and trainers.');



CREATE TABLE user_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    question TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    profile_pic VARCHAR(255) DEFAULT 'uploads/default.png',
    password VARCHAR(255) NOT NULL,
    pet_type VARCHAR(100),
    pet_picture VARCHAR(255) DEFAULT 'uploads/default_pet.png' 
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE user_pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    pet_type VARCHAR(100) NOT NULL,
    pet_picture VARCHAR(255) DEFAULT 'uploads/default_pet.png',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS adopters (
    a_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE, 
    preferences TEXT NOT NULL,
    adoption_date DATE NOT NULL,
    experience TEXT NOT NULL,
    address VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'
);

CREATE TABLE IF NOT EXISTS notifications (
    n_id INT AUTO_INCREMENT PRIMARY KEY,
    a_id INT NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (a_id) REFERENCES adopters(a_id) ON DELETE CASCADE
);



CREATE TABLE IF NOT EXISTS certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    adopter_email VARCHAR(255) NOT NULL,
    certificate_number VARCHAR(50) NOT NULL UNIQUE,
    date_of_issue DATE NOT NULL,
    pet_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (adopter_email) REFERENCES adopters(email) ON DELETE CASCADE
);

CREATE TABLE user_question_answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT,
    answer TEXT,
    user_id INT,
    answered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (question_id) REFERENCES user_questions(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);


CREATE TABLE rehomers_application (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    pet_choice VARCHAR(50),
    pet_age VARCHAR(10),
    pet_picture VARCHAR(255)
);

ALTER TABLE rehomers_application
ADD COLUMN approved TINYINT(1) DEFAULT 0;



CREATE TABLE vets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    experience INT NOT NULL,
    contact VARCHAR(50),
    image VARCHAR(255) NOT NULL
);


CREATE TABLE vet_appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    pet_name VARCHAR(100) NOT NULL,
    vet_id INT,
    appointment_date DATE,
    contact_info VARCHAR(50),
    FOREIGN KEY (vet_id) REFERENCES vets(id) ON DELETE CASCADE
);
ALTER TABLE vet_appointments 
ADD COLUMN email VARCHAR(255) NOT NULL,
ADD COLUMN time_slot VARCHAR(10) NOT NULL;


CREATE TABLE parks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(255) NOT NULL
);


CREATE TABLE competitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    location VARCHAR(255) NOT NULL,
    contact VARCHAR(50),
    how_to_win TEXT,
    previous_winners TEXT
);


INSERT INTO vets (name, specialization, experience, contact, image) VALUES
('Dr. Sarah Lee', 'Small Animal Surgery', 10, '017123549', 'vet1.jpg'),
('Dr. John Smith', 'Veterinary Dermatology', 8, '014502456', 'vet4.jpg'),
('Dr. Emily Davis', 'Animal Behavior', 12, '01569405075', 'vet2.jpg');



INSERT INTO parks (name, location) VALUES
('Central Park', '123 Park Avenue, Cityname'),
('Greenwood Park', '456 Green St, Cityname'),
('Sunshine Park', '789 Sunshine Blvd, Cityname');

ALTER TABLE parks ADD COLUMN image VARCHAR(255) NOT NULL;

UPDATE parks
SET image = 'park1.jpg'
WHERE id = 1;

UPDATE parks
SET image = 'park2.jpg'
WHERE id = 2;

UPDATE parks
SET image = 'park3.jpg'
WHERE id = 3;


INSERT INTO competitions (title, date, location, contact, how_to_win, previous_winners)
 VALUES
('Annual Pet Talent Show', '2024-11-01', 'Pet Event Center, Cityname', '123-456-7890', 
'Showcase your pet\'s best trick, behavior, or talent! Judges will be evaluating based on creativity, execution, and audience appeal.',
'Winner 2023: Bella the Beagle - Best trick: balancing 5 balls.'),
('Pet Fashion Parade', '+8801564474631', 'Downtown Plaza, Cityname', '+8801568754631', 
'Dress up your pets in their fanciest costumes. Judges will be scoring based on originality, detail, and pet comfort.',
'Winner 2023: Max the Poodle - Best Costume: Superhero Outfit.');


ALTER TABLE competitions ADD COLUMN image VARCHAR(255) NOT NULL;

UPDATE competitions
SET image = 'com.jpg'
WHERE id = 1;

UPDATE competitions
SET image = 'compi.jpg'
WHERE id = 2;


