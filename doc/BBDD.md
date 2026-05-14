# Documentació de Base de Dades (BBDD)

## 🔍 Documentació de les Consultes Principals en Pipeline 

Documentació de pipelines i consulta a bbdd

La tasca ens demana filtrar (READ) les dades que tenim tant a MongoDB com a phpMyAdmin i mostrar-les en gràfics, amb unes condicions específiques com el filtre d'HTTP, els minuts emprats per departament...

# Consultes SQL

En primer lloc, hem tractat les dades SQL per mostrar el consum dels departaments. Per fer-ho, com que treballem amb PHP, definim la variable, en aquest cas li diem $resultat, a aquesta li passem els resultats d'un SELECT que consulta la vista vista_consum_departaments, que ens retorna el nom del departament, el temps total dedicat i el nombre d'incidències:

$resultat = $mysqli->query("SELECT nomDepartament AS nom, 
                            tempsTotalDedicat AS temps, 
                            nombreIncidencies AS numInc 
                            FROM vista_consum_departaments");

$departaments = $resultat->fetch_all(MYSQLI_ASSOC);

Un cop tenim les dades, les separem en dos arrays per poder-les passar al gràfic. Fem un foreach que recorre tots els departaments i va afegint el temps i el nom als seus arrays corresponents:

$tempsArray = array();
$deptsArray = array();

foreach ($departaments as $unDepartament) {
    $tempsArray[] = $unDepartament["temps"];
    $deptsArray[] = $unDepartament["nom"];
}
$deptsArray contindrà els noms dels departaments, que faran de etiquetes al gràfic, i $tempsArray contindrà els minuts dedicats, que seran els valors.

A continuació, fem una segona consulta per obtenir les incidències obertes ordenades per prioritat i data d'inici. Per ordenar per prioritat fem servir la funció FIELD() de MySQL, que ens permet indicar nosaltres mateixos l'ordre dels valors, en aquest cas alta → mitjana → baixa. Dins de cada prioritat, les més recents surten primer gràcies al dataInici DESC:

$resInc = $mysqli->query("
    SELECT ID_INCIDENCIA AS idInc, 
            nomTecnic AS aula, 
            descripcioIncidencia AS descripcio,
           DATE(dataInici) AS dataIni, 
           PRIORITAT AS prioritat 
    FROM vista_informe_tecnics 
    ORDER BY FIELD(PRIORITAT, 'alta', 'mitjana', 'baixa'), dataInici DESC
");

$incidencies = $resInc->fetch_all(MYSQLI_ASSOC);

El DATE(dataInici) serveix per treure només la data sense l'hora, que és el que volem mostrar a la taula. Com a les consultes anteriors, acabem amb fetch_all(MYSQLI_ASSOC) per carregar tots els resultats en un array associatiu PHP.

# CONSULTES NOSQL:

La tasca ens demana registrar els loggs de la pàgina, és a dir, cada cop que algu accedeixi, mitjancant un logger, aquest registri l'entrada a mongodb, creant un document amb la url del lloc visitat, el mètode que s'ha fet servir (GET, POST...), Timestamp de l'accés,Informació bàsica del navegador i l'IP del client



