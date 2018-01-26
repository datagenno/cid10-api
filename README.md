# Sobre o Projeto

Trata-se de uma API feita em PHP utilizando [Elasticsearch](https://www.elastic.co/products/elasticsearch) como engine de busca importando os registros do CID10 (mais 12 mil).

### Para importar os dados:
    make import

### Para acessar o web container no docker
    make bash

### Créditos
Os dados utilizados foram baseados neste [gist](https://gist.github.com/manuholiveira/9441735) da [@manuholiveira](https://github.com/manuholiveira).

___

# API

## Busca [/v2/search/{pageStart}/{pageEnd}?q={term}]

### Buscar CID10 por condição ou código [GET]

+ Request (application/json)

    + Headers

            Authorization: Basic token

+ Parameters

    + term: neurof* (string, required)
    + pageStart: 0 (number, optional)
    + pageEnd: 0 (number, optional)


+ Response 200

        {
          "terms": "neurof*",
          "found": 1,
          "per_page": 30,
          "displayed": 1,
          "pages": 0,
          "current_page": 0,
          "results": [
              {
                  "code": "Q85.0",
                  "value": "Neurofibromatose (não-maligna)"
              }
          ]
        }

+ Response 404

        {
          "error": true,
          "message": "request_not_found"
        }

### Exemplos

* `/v2/search?q=dor`
* `/v2/search/0?q=dor*` (resultados da primeira página)
* `/v2/search/0/30?q=dor*` (30 resultados por página)
