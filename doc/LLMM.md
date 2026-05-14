# Documentació de Llenguatge de Marques (LLMM)

# Breu documentació de les funcionalitats JavaScript implementades

En el fitxer `estadistiques.php`, s'utilitza JavaScript per recollir les dades del backend i generar un gràfic de pastís que mostra el temps invertit per departament:

<script>
    // Selecciona l'element HTML <canvas> mitjançant el seu ID per saber on dibuixar el gràfic
    const ctx = document.getElementById('myChart');

    // Crea una nova instància de la llibreria Chart.js
    new Chart(ctx, {
        type: 'pie', // Defineix el tipus de gràfic: 'pie' és un gràfic de pastís (circular)
        
        data: {
            // 'labels' són els noms dels departaments (ex: Informàtica, Secretaria)
            // json_encode converteix l'array de PHP en un format que JavaScript pot entendre
            labels: <?= json_encode($deptsArray); ?>, 
            
            datasets: [{
                // 'data' són els valors numèrics (minuts totals d'actuació) enviats des de PHP
                data: <?= json_encode($tempsArray); ?>, 
                
                // Colors de fons per a cada porció del pastís (estil Bootstrap)
                backgroundColor: ['#0d6efd', '#6610f2', '#a8a8a8', '#d63384', '#dc3545', '#fd7e14', '#ffc107', '#198754'],
                
                borderWidth: 2,      // Gruix de la línia de separació entre porcions
                borderColor: '#ffffff' // Color blanc per a la vora per donar un aspecte més net
            }]
        },
        
        options: {
            plugins: {
                legend: {
                    position: 'bottom', // Col·loca la llegenda dels departaments a la part inferior
                    labels: {
                        usePointStyle: true, // Substitueix els quadrats de la llegenda per cercles
                        font: {
                            size: 10 // Defineix una mida de font petita per a una millor visualització
                        }
                    }
                }
            }
        }
    });
</script>

