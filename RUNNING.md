

<!-- local-development:start -->
# Desarrollo local

Puedes abrir este repositorio en VS Code, Antigravity o Sublime Text. El compilador y los servicios necesarios dependen del componente indicado abajo.

## Node.js

Usa los scripts y el archivo de bloqueo de cada componente; revisa `engines` antes de elegir Node. La máquina de revisión tiene Node 22.23.1, pero eso no certifica compatibilidad de las dependencias antiguas.

[IProyecto-SoftLibre-Laravel(Funcional)/package.json](<IProyecto-SoftLibre-Laravel(Funcional)/package.json>): sin scripts npm declarados.

```powershell
Set-Location 'IProyecto-SoftLibre-Laravel(Funcional)'
npm.cmd install
npm.cmd run
```

[MusicPlayer/package.json](<MusicPlayer/package.json>): `start`.

```powershell
Set-Location 'MusicPlayer'
npm.cmd install
npm.cmd run
```

[package.json](<package.json>): sin scripts npm declarados.

```powershell
Set-Location '.'
npm.cmd install
npm.cmd run
```

## Python

Crea un entorno por aplicación desde PyCharm o la CLI. Python 3.12 es el punto inicial de compatibilidad; no se presume que todo el código o sus paquetes antiguos ya lo soporten.

```powershell
py -3.12 -m venv .venv
```

No se detectó un archivo requirements. Hay que identificar los imports y declarar las dependencias antes de instalarlas.

## PHP

Usa un runtime PHP aislado compatible con la aplicación. Ejecuta Composer únicamente en la carpeta con `composer.json`; las aplicaciones Laravel antiguas requieren revisar también PHP y dependencias. Configura las credenciales de base de datos localmente.

## Componentes y validación

Inventario y compilaciones locales del 2026-11-15. Una compilación correcta no acredita todavía interacción, compatibilidad de base de datos, instalador ni despliegue.

| Componente | Tipo / destino | Validación |
| --- | --- | --- |
| [IProyecto-SoftLibre-Laravel(Funcional)/package.json](<IProyecto-SoftLibre-Laravel(Funcional)/package.json>) | node | Sin ejecutar |
| [MusicPlayer/package.json](<MusicPlayer/package.json>) | node | Sin ejecutar |
| [package.json](<package.json>) | node | Sin ejecutar |

## Archivos ignorados

`.gitignore` excluye credenciales locales, estado del editor y salidas de las herramientas detectadas. No deja de versionar archivos que ya estaban en Git. Los manifiestos, archivos de bloqueo, recursos fuente y scripts de esquema forman parte del código.
<!-- local-development:end -->
