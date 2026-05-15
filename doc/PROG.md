# Documentació de Programació (PROG)

## Link Taiga

https://tree.taiga.io/project/a25jawmohbou-projecte-gi3p/timeline

## Link GitHub

https://github.com/inspedralbes/projecte-1dam-25-26-dam1_grup4-1.git

## Link Penpot

https://design.penpot.app/#/view?file-id=29a60c49-971d-80dc-8007-e7079f4cf328&page-id=6778173c-fbf4-8077-8004-a37f50a5020f&section=interactions&index=0&share-id=8c927302-d076-8020-8008-00b641c8da1f

## Diagrama de casos d'ús

```mermaid
flowchart LR
  Professor --> UC1([Crear incidència])
  Professor --> UC2([Consultar incidència])

  Tècnic --> UC3([Escollir incidència a arreglar])
  Tècnic --> UC4([Modificar estat incidència])
  Tècnic --> UC5([Registrar actuació])

  Administrador --> UC6([Assignar incidència])
  Administrador --> UC7([Assignar prioritat])
  Administrador --> UC8([Consultar informe de tècnics])
  Administrador --> UC9([Consultar estadístiques d'accés])
```