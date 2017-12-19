# Insphptor

This repository represent an micro framework for calculate PHP projects metrics. Our objective is to increase the use of metrics to measure quality in a simple way.

## Get started

To get started, run the Composer command:

```shell
composer global require leonardovilarinho/insphptor
```

Next, in your project directory, run the `insphptor init` command, to create insphptor settings file (insphptor.yml). Finally run `insphptor run:export -o` to calculate metrics and open in your browser.

## Settings

Use `insphptor.yml` file in root directory your projeto to configure the analyze.

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

## Commands

- `insphptor init`: create insphptor.yml file based in your answers.
- `insphptor run`: calculate metrics and display result in terminal.
- `insphptor run:export`: calculate metricsm display result in terminal and export json file for view system.
- `insphptor start`: server your projects result in browser.
- `insphptor clean`: delet all data.

### Options

- `inphptor --help`: see list with all commands.
- `inphptor run:export -o`: open result in grapic browser.
- `inphptor run:export -f`: generate an alias for this result.