<!DOCTYPE html>
<html lang="ca">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Landing Page</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>


body {
   margin: 0;
   height: 100vh;
   font-family: sans-serif;
   background-color: #f3f4f6;
   background-image: url("fonslandingpage.png");
   background-size: cover;
   background-position: center;
          
   display: flex;
   flex-direction: column;
   align-items: center;
   justify-content: flex-start;
   padding-top: 80px;
}


.header-container {
   background-color: white;
   padding: 60px 100px;
   text-align: center;
   box-shadow: 0 4px 15px rgba(0,0,0,0.1);
   margin-bottom: 60px;
   width: fit-content;
}


.header-container h1{
   margin: 0;
   font-size: 3rem;
   font-weight: bold;
   color: #333;
   letter-spacing: 1px;
}


.buttons-grid {
   display: grid;
   grid-template-columns: 1fr 1fr;
   gap: 20px;
   width: 90%;
   max-width: 900px;
   justify-items: center;
}


.button{
   font-size: 2.5rem;
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
   opacity: 0.8;
}


.button1 {
   background-color: #3b82f6;
   padding: 40px 0;
}


.button2 {
   background-color: #636e80;
   padding: 40px 0;
}


.button3 {
   background-color: #f97316;
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
  <img src="logo.png" alt="Logo" class="logo">


<div class="header-container">
   <h1>Gestió d'incidències</h1>
   <h1>INS Pedralbes</h1>
</div>


<div class="buttons-grid">
   <button class="button button1" href="#article1">USUARI</button>
   <button class="button button2" href="#hola">TÈCNIC</button>
   <button class="button button3" onclick="location.href='#article3'">ADMINISTRADOR</button>
</div>


</body>
</html>
