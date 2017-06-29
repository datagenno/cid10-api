# O projeto
  Trata-se de uma API feita em PHP utilizando elastic search como engine de busca importando os registros do CID10 (mais 12 mil)

# Para importar os dados:
  make run-command (And then type "DiseaseImporter")

# Para acessar o web container no docker
  make access-web-container

# Exemplos do endPoints
  * /v1/diseases/dor*
  * /v1/diseases/dor*/0 (with page started from zero)
  * /v1/diseases/dor*/0/30 (with page and results by page)

# Créditos
  Os dados foram removidos daqui: https://gist.github.com/manuholiveira/9441735
