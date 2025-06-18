# Mini Social Media Portal - Laravel

## 👨‍💻 Developed by: Amit Yadav

### 🛠 Features Implemented:
- User Authentication (Register/Login/Logout)
- Profile Edit + Profile Picture Upload
- Friend Request System (Send/Accept/Reject)
- Email Notification via Mailtrap
- Friend Search
- Dashboard: Incoming, Pending, Accepted Requests
- Clean UI with Tailwind CSS

### 🧪 Tech Stack:
- Laravel 11
- Breeze (Starter Kit)
- MySQL (XAMPP)
- Mailtrap for testing email

### 📸 Screenshots:
- [x] Login Page
      ![image](https://github.com/user-attachments/assets/46c7c469-3839-4a58-935f-17792c3babbd)

- [x] Register Page
      ![image](https://github.com/user-attachments/assets/6e50c0e6-568b-44eb-bcc7-c5e7dbc3f122)

- [x] Profile page
       ![image](https://github.com/user-attachments/assets/7e63669d-21ad-4815-a4db-57f387dacb89)

- [x] Dashboard Page
      ![image](https://github.com/user-attachments/assets/d8c4d619-2579-4880-a8ef-1cf862b3a254)

- [x] Friends tab + request buttons
      ![image](https://github.com/user-attachments/assets/0f8b3d3d-9827-403b-ad5c-2499648caaf2)

- [x] Mailtrap email
      ![image](https://github.com/user-attachments/assets/324c92ad-e9bd-480a-847d-70a6d4897f93)


### ⏳ Time Taken:
- 5 hours (total coding & setup)

## 🧾 How to Run This Project Locally:

```bash
git clone https://github.com/AmitYadav1155/Social-Media-Portal.git
cd Social-Media-Portal
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
