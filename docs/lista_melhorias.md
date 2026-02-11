# Melhorias e Diferenciais

O projeto foi desenvolvido indo além dos requisitos básicos. Abaixo, as três principais melhorias aplicadas:

1. **Monitoramento de Performance**
   Implementei o registro do **tempo de resposta (ms)** de cada requisição no banco de dados. Isso permite monitorar a latência da aplicação e identificar gargalos na comunicação com a API externa.

2. **Lazy Loading (Carregamento Assíncrono)**
   Para evitar travamentos devido à lentidão da SWAPI, a página carrega instantaneamente e os dados pesados (listas de personagens e planetas) são buscados em segundo plano via AJAX, melhorando drasticamente a UX.

3. **Exibição Completa**
   Além de Filmes e Personagens (solicitados no teste), expandi o sistema para incluir a visualização detalhada de **Naves (Starships)**, **Veículos** e **Espécies**, criando endpoints e telas específicas para essas entidades.