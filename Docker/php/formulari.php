<!DOCTYPE html>
<html lang="ca">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Questionari</title>


 <style>
   body {
     font-family: Arial, sans-serif;
     margin: 20px;
     background-color: #f4f4f4;
   }


   fieldset {
     margin-bottom: 20px;
     padding: 10px;
   }


   legend {
     font-weight: bold;
     padding: 0 10px;
   }


   label {
     display: block;
     margin-top: 10px;
   }


   input[type="text"],
   textarea {
     width: 100%;
     padding: 8px;
     box-sizing: border-box;
   }


   input[type="submit"] {
     background-color: #4CAF50;
     color: white;
     padding: 10px 20px;
     border: none;
     cursor: pointer;
   }


   input[type="submit"]:hover {
     background-color: #45a049;
   }
 </style>
</head>
<body>
  <h2 style="text-align: center;">FORMULARI</h2>
 <h2 style="text-align: center;">CREAR INCIDÈNCIA</h2>


 <form action="https://daw.inspedralbes.cat/form/action.php">


   <fieldset style="background-color: #fff4f4; border: 1px solid #555;">
     <legend>Departament</legend>
    
        <label for="Nom"></label>
     <input type="text" id="Adreça" name="Adreça">
   </fieldset>


 


   </fieldset>
     <br>
   <br>
   <fieldset style="background-color: #ffe7e7; border: 1px solid #555;">
     <legend>Descripció de la incidència</legend>
     <label for="obs">Observacions</label><br>
      <textarea id="obs" name="obs" rows="6" cols="100" style="resize: none;" placeholder="Pots escriure aquí la teva observació."></textarea><br><br>
   
   </fieldset>
    
 
   </fieldset>




 </form>
</body>
</html>
