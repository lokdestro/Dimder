CREATE TABLE User (
    id INT PRIMARY KEY AUTO_INCREMENT,  
    name VARCHAR(100) NOT NULL,         
    email VARCHAR(100) UNIQUE NOT NULL,  
    password VARCHAR(255) NOT NULL,      
    birth_date DATE,                     
    gender ENUM('male', 'female', 'other'),
    interests TEXT                       
);


CREATE TABLE Message (
    id INT PRIMARY KEY AUTO_INCREMENT,
    sender_id INT NOT NULL,             
    receiver_id INT NOT NULL,           
    content TEXT NOT NULL,              
    sent_date DATETIME DEFAULT CURRENT_TIMESTAMP, 
    FOREIGN KEY (sender_id) REFERENCES User(id),  
    FOREIGN KEY (receiver_id) REFERENCES User(id) 
);


CREATE TABLE Profile (
    id INT PRIMARY KEY AUTO_INCREMENT, 
    user_id INT NOT NULL,             
    photo VARCHAR(255),              
    bio TEXT,                        
    location VARCHAR(100),          
    FOREIGN KEY (user_id) REFERENCES User(id)
);