# Sistema de Inventario

## Descripción:
El siguiente proyecto esta desarrollado utilizando el Framework Symfony en su versión más reciente (4.1).

## TODO:
1. [X] Crear proyecto en Symfony 4.
1. [X] Configurar proyecto base en Symfony 4.
1. [X] Implementar Fake JSON Server para datos. (***json-server***) 
1. [X] Implementar API del Sistema.
1. [X] Implementar Events y Subscribers para Item sacado del Inventario y Item Caducado.
1. [X] Implemntar LOG's cuando los subscribers se ejecuten para demostrar funcionalidad de eventos.
1. [ ] Comentar estructura del código.
1. [X] Test Unitarios.
1. [ ] Interfaz visual con CRUD de inventario 
1. [ ] Test Funcionales.


## Arquitectura:
Para la arquitectura, por temas de tiempo, utilizamos la por defecto por symfony la cual sigue el patrón MVC, yo lo llamo
***MVC Plus*** ya que gracias a como esta estructurado el framework, y las buenas prácticas recomendadas por
sus desarrolladores, nos permite mantener una estrutura de código limpia, sólida, flexible y sobre todo escalable.

Aún cuando por temas de tiempo no se pudo hacer, me hubiese gustado implementar la "***Arquitectura Cebolla***" ***(Onion Architecture)***, ya
que de cierta manera nos permite añadir más capas a la estructura, distribuyendolo mejor para garantizar entre otras cosas que el
código sea testeable, independiente del framework y con una lógica de negocio mas robústa. Esto motivado a que hoy este test esta desarrollado usando
Symfony por ser un framework robusto y el cual considero que esta marcando tendencia entre todos los frameworks de PHP, pero que si a futuro
se quisiera migrar a otro framework de PHP, habiendo utilizando el onion architecture, pudiese ser transparente prácticamente el cambio de framework.  

## Seguridad:
No pude implementar nada de seguridad pero me hubiese gustado entre otras cosas:

- Proteger cada endpoint mediante el uso de autenticación por tokens, pudiendo haber usado ***oAuth2*** ó ***JWT***. Personalmente me gusta
JWT por su nivel de seguridad y la practicidad de implementación.
- Restringir las rutas del api por roles y obligarlas a poder ser accedidas por usuarios autenticados.
- Se pudo haber utilizado los votantes de Symfony (Symfony Voters), para por ejemplo autorizar a ciertos perfiles a realizar ciertas operaciones disponibles. 

## Otros aspectos relevantes:
- Todo el código escrito esta documentado, optimizado para PHP 7.x, e implementando las mejores prácticas de Symfony y sus estandares PSR (PSR-1, PSR-2 y PSR-4)
- Por temas de tiempo, pude haber validado mejor los datos de entrada y salida. Symfony ayuda mucho a esto con los componentes
de Validation y Validation Constraints.
- Me faltó la documentación del API, es decir, utilizar una librería que se integra con Symfony y permite mediente anotaciones
documentar cada endpoint. Con esto sería posible exponer una interfaz web para poder tener acceso a los endpoints disponibles y su
respectiva documentación.

## Requerimientos de Ejecución:
- Tener instalado Composer
- Tener instalado Node con su gestor de paquetes NPM
- PHP >= 7.1

## Instrucciones de Configuración
- Nos situamos en la raiz del proyecto y ejecutamos:

```
composer install
```

- Seguidamente, descargamos paquetes necesarios y habilitamos el entorno para las pruebas unitarias.

```
./bin/phpunit
```

- y luego ejecutamos lo siguiente para instalar el fake api json server

```
npm install -g json-server
```

- Posteriormente, en una terminal iniciamos el servidor para exponer un fake api para los datos.

```
json-server --watch public/db.json
```

- Y en otra instancia de nuestra terminal, ejecutamos:

```
php bin/console server:run
```

Por defecto, nuestro fake api para los datos debe estar ejecutandose sobre la ruta: http://localhost:3000 y
el servidor del API como tal del sistema de inventario en http:127.0.0.1:8000. Son las rutas configuradas en el
fichero ***.env*** como parte de la configuración del sistema hecho en symfony.

## Pruebas Unitarias (PHPUnit)
Se realizaron pruebas unitarias a los endpoints definidos para el inventario pero:
- Quedo pendiente por falta de tiempo hacer pruebas unitarias y funcionales a las clases definidas.
- Por temas de tiempo, cuando se ejecuta el test unitario, se actualiza el fichero public/db.json, por ende si se desea realizar varias veces el test, hay que borrar
el item de inventario cuyo id es 999.

Para ejecutar las pruebas unitarias se debe:

- Situarse en la raiz del proyecto.
- Ejecutar el siguiente comando:
```
./bin/phpunit
```

## Interfaz Gráfica:
Por temas de tiempo me hubiese gustado hacer una interfaz gráfica para implementar un CRUD y poder consumir los endpoints definidos. Hubiese podido utilizar
una interfaz sencilla utilizando netamente los componentes de symfony tanto para backend como para frontend, o pudiese haber usado por ejemplo Vue.js, en combinación con
Bower o NPM (Gestion de librerías), Gulp (Automatización de procesos), Webpack encore (Compilador o empaquetador de módulos, se integra nativamente con el framework en la version 4 de Symfony)

## Aclaratoria de Implementación
Debido a los requerimientos del test, y el tiempo de implementación, veran en el código cosas que fueron 
implementadas a posta en pro de hacer el test funcional pero que en un entorno real no se llevarían a cabo de la 
misma manera obviamente. Un ejemplo de esto es el uso de un fake json api server para el almacenamiento y consulta de los datos.

Por otro lado, como se esta utilizando un fake json api server para proporcionar datos de prueba, cuando un se realiza una busqueda
por ID y este no existe, arroja una excepción, la cual controlo, y muestro como error 500 pese a que en el message de la excepción
indica que es un 404, refiriendose a que el fake json api server no ha encontrado el elemento.

## Postman Collections
He exportado mi colección de postman con los endpoints definidos para su fácil visualización. Para descargar la colección
[click aqui](goal-systems-api.postman_collection.json), Elegir RAW del fichero y descargar en el ordenador. Importar la colección al postman.
