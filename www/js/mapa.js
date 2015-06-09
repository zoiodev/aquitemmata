// Inicia o mapa com o Leaflet
var map = L.map('mapa', {center: [0,0], zoom: 2});

// Adiciona camada base (tiles do OpenStreetMap)
L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

// Camadas do CartoDB
var cdbLayers = [
  // Polígonos
  {
    sql: "SELECT * FROM ucstodas WHERE codigo_u11 = '0000.33.1512'",
    cartocss: "#polygon { line-width:2; line-color: #000; line-opacity: 1; }"
  },
  {
    sql: "SELECT ST_Intersection(rem.the_geom_webmercator, uc.the_geom_webmercator) AS the_geom_webmercator, rem.cartodb_id, rem.legenda FROM atlas_rema2013_naturais as rem, ucstodas as uc WHERE uc.codigo_u11 = '0000.33.1512' AND ST_Intersects(rem.the_geom, uc.the_geom)",
    cartocss: '#rem { polygon-opacity: 0.7; line-color: #FFF; line-width: 0.2; line-opacity: 1; } #atlas_rema2013_naturais[legenda="Mangue"] { polygon-fill: #A6CEE3; } #atlas_rema2013_naturais[legenda="Mata"] { polygon-fill: #33a02c; } #atlas_rema2013_naturais[legenda="Naturais não florestais"] { polygon-fill: #F84F40; } #atlas_rema2013_naturais[legenda="Restinga"] { polygon-fill: #7B00B4; }'
  }
];

// Mais informações: http://docs.cartodb.com/cartodb-platform/cartodb-js.html#core-api-functionality
cartodb.Tiles.getTiles({
  user_name: 'sosma',
  sublayers: cdbLayers,
  }, function(tiles, err) {
    $.each(tiles.tiles, function(i, tile) {
      // Cria camadas no Leaflet e associa ao mapa
      L.tileLayer(tile).addTo(map);
    });
});

// Inicia SQL do CartoDB no usuário
// Mais sobre consultas SQL: http://docs.cartodb.com/tips-and-tricks.html
var sql = new cartodb.SQL({ user: 'sosma' });

// Ajusta mapa aos limites da camada
sql.getBounds("SELECT * FROM ucstodas WHERE codigo_u11 = '0000.33.1512'").done(function(bounds) {
  map.fitBounds(bounds);
});
