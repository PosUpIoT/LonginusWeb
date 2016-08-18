# LonguinusApp

- Baixem o Git (https://git-scm.com/)
- Instalem o Git
- Através do <b>Git Bash</b> rode na linha de comando: git clone --bare https://github.com/PosUpIoT/longuinusapp.git
- Você esta com o projeto "copiado" no ambiente local
- Quer pegar a ultima versão do projeto?
  - Rodar o comando git pull
    - Se você fez algumas alterações antes de fazer o git pull <i>provávelmente</i> vai dar conflito de arquivos
- Fez alterações? Siga a seguinte lógica:
  - Criou arquivo novo? 
    - Rodar o comando git add --all 
    - Seguido de git commit --add --m="Mensagem explicando o que você fez"
    - Seguido de git push
  - Fez alterações em arquivos já existentes?
    - Seguido de git commit --add --m="Mensagem explicando o que você fez"
    - Seguido de git push

Duvidas? Acessem e leiam: http://rogerdudler.github.io/git-guide/

# LonginusSearchTeam

Instrução para testes do trabalho do Grupo 4 (implementação da busca e feed)
1. Garanta que o url do projeto (config.php - variável $config['base_url']) está correta - indicio que não está: assets não encontrados no load
2. Garanta que você rodou o comando composer install na raiz do projeto para instalar os pacotes necessários para que o projeto rode - os pacotes Faker (para gerar falsas informações para testes) e Gravatar (associar imagens de avatar aos usuarios) foram instalados
3. Execute o arquivo public/sql/longinus.sql para criação de tabelas
4. Acesse os caminhos /category/seed e /post/seed para que sejam criados a massa de dados de teste
5. Thats it!

# Considerações Search e Feed
    
- O feed de buscas não é geolocalizado (por mais que contenha informações de distancia) para garantir que a página inicial nao fique vazia
- A barra lateral "RECENT IN YOUR AREA" é geolocalizada- Raio para busca padrão 30km (para pesquisa avançada é possível alterar tanto o posicionamento quanto o raio)
- Consideramos nas buscas somente status 1 e 2 seguindo esta idéia:
    +post.status = 1 (publicado)
    +post.status = 2 (finalizado)
    +post.status = 3 (bloqueado)
- Para km o calculo da distância é feito com o valor 6371 e em milhas 3959
- Para as propriedades, determinamos caso o property_value na tabela category_properties seja vazio é um campo input de texto, caso contrário, se tiver 2 níveis o primeiro nível é um radio e o segundo um select, se tiver somente um nível é um radio