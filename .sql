-- Student Table --
CREATE TABLE tuition_students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    dob DATE DEFAULT NULL,
    gender ENUM('Male', 'Female', 'Other') DEFAULT NULL,
    class_grade VARCHAR(50) NOT NULL,
    school VARCHAR(150) DEFAULT NULL,
    subjects VARCHAR(255) DEFAULT NULL,
    address TEXT DEFAULT NULL,
    parent_name VARCHAR(100) DEFAULT NULL,
    parent_phone VARCHAR(15) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    profile_photo VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

ALTER TABLE tuition_students
ADD COLUMN profile_photo VARCHAR(255) DEFAULT 'default.png' AFTER email;

-- Fees Payment Table --
CREATE TABLE fee_payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    payment_id VARCHAR(100) NOT NULL UNIQUE,
    student_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('Paid','Pending','Failed') NOT NULL DEFAULT 'Pending',
    paid_on DATE NOT NULL,
    paid_at TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

-- extra fields for future scalability
payment_method VARCHAR(50) DEFAULT 'Razorpay', -- Razorpay, Cash, UPI, etc.
remarks TEXT DEFAULT NULL, -- admin notes
receipt_url VARCHAR(255) DEFAULT NULL, -- link to generated PDF receipt

-- relation with tuition_students
CONSTRAINT fk_student FOREIGN KEY (student_id) REFERENCES tuition_students(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;