Tehnologii folosite:
    - Angular Framework pentru FrontEnd;
    - PHP pentru BackEnd;
    - SQL cu motorul MySql, pentru baza de date;

In fisierul docker-compose.yml se initializeaza 4 servicii:
    - serviciul pentru autentificare (UserService)
    - serviciul pentru administrare postari (PostService)
    - serviciul cu motorul de baze de date MySql
    - serviciul pentru interfata de administrare a bazei de date (PHPMyAdmin)

UserService este serviciul de tip API, responsabil cu autentificarea si crearea de utilizatori. Autentificare se realizeaza prin JWT-uri(JSON Web Tokens). JWT-ul este salvat in LocalStorage dupa autentificare. 

PostService este serviciul de tip API, responsabil cu administrarea postarilor. Serviciul functioneaza folosind token-ul generat in UserService si permite operatiuni de listare, creere, editare si stergere a postarilor, in functie de acces.

