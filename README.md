# C4 Architecture Model Diagram Generator

This application was inspired by C4 software architecture model, as [described by Simon Brown](https://www.voxxed.com/blog/2014/10/simple-sketches-for-diagramming-your-software-architecture/).


**Note: Still WIP.**

## Requirements

* PHP 5.5+
* Graphviz (dor)

## Installation

Right now you can install C4ML by composer. More options to come in future.

```bash
$ composer require viliam-husar/c4ml
```

After installation you can run C4ML by:

```bash
$ bin/vendor/c4ml
```

## Syntax

See example.c4ml for syntax. Some limitations:

* You need to use unique id for each part of model.
* When defining usages, you can refer only from/to: Container, External System, Internal User, External User.

## Usage

There are several options for C4ML to process your model. To see them all just use the --help option:

### Specify output format

Because C4ML is using Graphviz for rendering, you might render your model diagram in multiple formats (svg is default).

```bash
$ bin/vendor/c4ml example.c4ml example.svg -f svg
$ bin/vendor/c4ml example.c4ml example.png -f png
```

### Select internal systems with containers view

By default all internal systems are displayed in container view and with all related elements. If you have
large model with multiple internal systems, you might select which of them should be displayed in this way.
All other internal systems will be displayed in system view and only if required by selected internal systems.

```bash
$ bin/vendor/c4ml example.c4ml example.svg -s site
$ bin/vendor/c4ml example.c4ml example.svg -s site -s orders
```

### Highlight elements (Containers, External Systems, Internal Users, External Users)

In some cases you may need to highlight one or more elements in you diagram. For this purpose use
option `-l|--highligt`:

```bash
$ bin/vendor/c4ml example.c4ml example.svg -l site
$ bin/vendor/c4ml example.c4ml example.svg -l site -l orders
```

