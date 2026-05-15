# Documentació de Base de Dades (BBDD)

## Documentació de les Consultes Principals en Pipeline

Documentació de pipelines i consulta a bbdd

La tasca ens demana filtrar (READ) les dades que tenim tant a MongoDB com a phpMyAdmin i mostrar-les en gràfics, amb unes condicions específiques com el filtre d'HTTP, els minuts emprats per departament...

---

## Consultes SQL

En primer lloc, hem tractat les dades SQL per mostrar el consum dels departaments. Per fer-ho, com que treballem amb PHP, definim la variable, en aquest cas li diem `$resultat`, a aquesta li passem els resultats d'un `SELECT` que consulta la vista `vista_consum_departaments`, que ens retorna el nom del departament, el temps total dedicat i el nombre d'incidències:

```php
$resultat = $mysqli->query("SELECT nomDepartament AS nom, 
                            tempsTotalDedicat AS temps, 
                            nombreIncidencies AS numInc 
                            FROM vista_consum_departaments");
$departaments = $resultat->fetch_all(MYSQLI_ASSOC);
```

Un cop tenim les dades, les separem en dos arrays per poder-les passar al gràfic. Fem un `foreach` que recorre tots els departaments i va afegint el temps i el nom als seus arrays corresponents:

```php
$tempsArray = array();
$deptsArray = array();

foreach ($departaments as $unDepartament) {
    $tempsArray[] = $unDepartament["temps"];
    $deptsArray[] = $unDepartament["nom"];
}
```

`$deptsArray` contindrà els noms dels departaments, que faran d'etiquetes al gràfic, i `$tempsArray` contindrà els minuts dedicats, que seran els valors.

A continuació, fem una segona consulta per obtenir les incidències obertes ordenades per prioritat i data d'inici. Per ordenar per prioritat fem servir la funció `FIELD()` de MySQL, que ens permet indicar nosaltres mateixos l'ordre dels valors, en aquest cas **alta → mitjana → baixa**. Dins de cada prioritat, les més recents surten primer gràcies al `dataInici DESC`:

```php
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
```

El `DATE(dataInici)` serveix per treure només la data sense l'hora, que és el que volem mostrar a la taula. Com a les consultes anteriors, acabem amb `fetch_all(MYSQLI_ASSOC)` per carregar tots els resultats en un array associatiu PHP.

---

## Consultes NoSQL

La tasca ens demana registrar els logs de la pàgina, és a dir, cada cop que algú accedeixi, mitjançant un logger, aquest registri l'entrada a MongoDB, creant un document amb:

- La **URL** del lloc visitat
- El **mètode** que s'ha fet servir (`GET`, `POST`...)
- El **timestamp** de l'accés
- Informació bàsica del **navegador**
- La **IP** del client

### Inserció del log (`logger.php`)

Cada cop que un usuari accedeix a qualsevol pàgina, el logger recull automàticament la seva informació i la desa a MongoDB.

**1. Obtenció de la IP real del client**

Com que l'aplicació pot estar darrere d'un proxy o balancejador de càrrega, la IP no sempre es troba a `REMOTE_ADDR`. Per això es comproven les capçaleres en ordre de prioritat:

```php
$ip = $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['HTTP_X_REAL_IP']
    ?? $_SERVER['REMOTE_ADDR']
    ?? 'unknown';

// Si la capçalera conté múltiples IPs separades per comes, agafem només la primera (la del client real)
if (str_contains($ip, ',')) {
    $ip = trim(explode(',', $ip)[0]);
}
```

**2. Detecció del navegador**

Es llegeix la capçalera `HTTP_USER_AGENT` i es compara amb paraules clau de cada navegador. L'ordre és important: `Edg` s'ha de comprovar abans que `Chrome` perquè Edge també conté la paraula "Chrome" al seu user agent:

```php
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
$navegador = 'Desconegut';

if (strpos($userAgent, 'Firefox') !== false) {
    $navegador = 'Firefox';
} elseif (strpos($userAgent, 'Edg') !== false) {
    $navegador = 'Edge';
} elseif (strpos($userAgent, 'Chrome') !== false) {
    $navegador = 'Chrome';
} elseif (strpos($userAgent, 'Safari') !== false) {
    $navegador = 'Safari';
} elseif (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) {
    $navegador = 'Opera';
}
```

**3. Construcció i inserció del document a MongoDB**

Es construeix la URL completa combinant el protocol (`http://` o `https://`), el host i la ruta. Tot plegat s'insereix com un document a la col·lecció de logs:

```php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    ? 'https://'
    : 'http://';

$log = [
    'url'        => $protocol .
                    ($_SERVER['HTTP_HOST'] ?? 'unknown') .
                    ($_SERVER['REQUEST_URI'] ?? '/'),
    'metode'     => $_SERVER['REQUEST_METHOD'] ?? 'unknown',  // GET, POST...
    'usuari'     => null,                                      // S'omple si l'usuari està autenticat
    'timestamp'  => new MongoDB\BSON\UTCDateTime(),            // Moment exacte de l'accés
    'navegador'  => $navegador,# Documentació de Base de Dades (BBDD)

## Documentació de les Consultes Principals en Pipeline 

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




    'user_agent' => $userAgent,
    'ip'         => $ip,
];

$collection->insertOne($log);
```

---

### Consultes i Pipelines d'agregació (`estadistiques.php`)

Un cop tenim els logs emmagatzemats, construïm filtres dinàmics i pipelines d'agregació per consultar-los.

**1. Construcció dinàmica dels filtres**

Segons els valors que l'usuari hagi introduït al formulari, s'afegeixen condicions al filtre `$match`:

```php
$match = [];

// Filtre per data: converteix la data a timestamps de MongoDB (inici i fi del dia)
if ($filtreData) {
    $inici = new MongoDB\BSON\UTCDateTime(strtotime($filtreData) * 1000);
    $fi    = new MongoDB\BSON\UTCDateTime((strtotime($filtreData) + 86400) * 1000);
    $match['timestamp'] = ['$gte' => $inici, '$lt' => $fi];
}

// Filtre per usuari si s'ha escrit
if ($filtreUsuari) $match['usuari'] = $filtreUsuari;

// Filtre per URL (cerca parcial, sense distingir majúscules/minúscules)
if ($filtrePagina) $match['url'] = ['$regex' => $filtrePagina, '$options' => 'i'];

// Prepara l'etapa $match per usar-la dins les pipelines
$matchStage = ['$match' => (object)$match];

// Compta el total d'accessos amb els filtres aplicats
$totalAccessos = $collection->countDocuments($match ?: []);
```

**2. Pipeline: pàgines més visitades**

Aquesta pipeline agrupa els logs per URL, IP i navegador, compta quantes vegades apareix cada combinació i retorna les 20 més freqüents ordenades de major a menor:

```php
$paginesMesVisitades = $collection->aggregate([
    $matchStage,                        // Etapa 1: aplica els filtres actius
    [
        '$group' => [
            '_id' => [
                'url'      => '$url',       // Agrupa per URL visitada
                'ip'       => '$ip',        // ... i per IP del client
                'navegador'=> '$navegador'  // ... i per navegador
            ],
            'total' => ['$sum' => 1]        // Compta les ocurrències de cada grup
        ]
    ],
    ['$sort'  => ['total' => -1]],      // Etapa 3: ordena de més a menys visites
    ['$limit' => 20],                   // Etapa 4: limita el resultat a les 20 primeres
])->toArray();
```