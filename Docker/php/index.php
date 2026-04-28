<!DOCTYPE html>
<html lang="ca">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Landing Page</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
   <style>
      body {
         margin: 0;
         height: 100vh;
         font-family: 'Montserrat', sans-serif;
         background-image: linear-gradient(rgba(248, 250, 252, 0.8), rgba(248, 250, 252, 0.8)), url("fonslandingpage.png");
         background-size: cover;
         background-position: center;
         display: flex;
         flex-direction: column;
         justify-content: flex-start;
         padding-top: 0;
         position: sticky;
         top: 0;
         z-index: 1000;
      }


      .header-container {
         background-color: rgba(144, 178, 216, 0.8);
         width: 100%;
         padding: 20px 0;
         text-align: center;
         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
         margin-bottom: 80px;
         border-radius: 0;
      }

      .header-container h1 {
         font-size: 2rem;
         margin: 5px 0;
      }

      .buttons-grid {
         display: grid;
         grid-template-columns: 1fr 1fr;
         gap: 24px;
         width: 90%;
         max-width: 900px;
         margin: 0 auto;
         justify-items: center;
      }


      .button {
         font-size: 2.5rem;
         font-family: 'Montserrat', sans-serif;
         font-weight: bold;
         border: none;
         color: white;
         cursor: pointer;
         text-transform: uppercase;
         transition: opacity 0.2s;
         width: 100%;
         box-sizing: border-box;
      }

      .button:hover {
         transform: translateY(-4px);
         box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
         opacity: 1 !important;
      }

      .button {
         font-size: 1.4rem;
         font-weight: 700;
         color: white;
         border-radius: 12px;
         transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
         display: flex;
         align-items: center;
         justify-content: center;
         padding: 30px 0;
         border: none;
         box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      }

      .button1 {
         background-color: #2563eb;
         padding: 40px 0;
      }

      .button2 {
         background-color: #475569;
         padding: 40px 0;
      }


      .button3 {
         background-color: #ea580c;
         grid-column: span 2;
         margin: 0 auto;
         width: 60%;
         margin-top: 10px;
         padding: 40px 0;
      }


      .logo {
         position: absolute;
         top: 20px;
         left: 20px;
         width: 150px;
         height: auto;
      }
   </style>
</head>

<body>
   <main>

      <img src="logo.png" alt="Logo" class="logo">


      <div class="header-container">
         <h1>GESTIÓ D'INCIDÈNCIES</h1>
         <h1>INS PEDRALBES</h1>
      </div>


      <div class="buttons-grid">
         <a href="usuari.php" class="button button1 text-decoration-none text-center">USUARI</a>
         <a href="tecnic.php" class="button button2 text-decoration-none text-center">TÈCNIC</a>
         <a href="llistar.php" class="button button3 text-decoration-none text-center">ADMINISTRADOR</a>
      </div>

   </main>
</body>

</html>
<?php include 'footer.php'; ?>