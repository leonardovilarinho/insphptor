# Insphptor

Este repositório representa uma microestrutura para calcular métricas de projetos PHP. Nosso objetivo é aumentar o uso de métricas para medir a qualidade de maneira simples.


## Para começar

Para começar, execute o comando Composer:

```shell
composer global require leonardovilarinho/insphptor
```

Em seguida, no diretório do seu projeto, execute o comando `insphptor init`, para criar o arquivo de configurações do insphptor (insphptor.yml). Finalmente execute `insphptor run: export -o` para calcular métricas e abrir no seu navegador.

## Configurações

Use o arquivo `insphptor.yml` no diretório raiz do seu projeto para configurar a análise.

```
name: Insphptor Project
export: json
git: auto
level: normal
rank: 6
hide:
    - interface
    - file
only:
    - source
views:
    overview: insphptor-overview
```

## Comandos

- `insphptor init`: crie o arquivo insphptor.yml com base nas suas respostas.
- `insphptor run`: calcular métricas e exibir resultado no terminal.
- `insphptor run:export`: calcular o resultado da exibição metricsm no terminal e exportar o arquivo json para o sistema de visualização.
- `insphptor start`: Os resultados do seu projeto são mostrados no navegador.
- `insphptor clean`: Deleta todos os arquivos.

### Options

- `inphptor --help`: veja a lista com todos os comandos.
- `inphptor run:export -o`: Resultado aberto no navegador gráfico.
- `inphptor run:export -f`: Gera um alias para este resultado.