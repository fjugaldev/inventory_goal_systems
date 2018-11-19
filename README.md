# Sistema de Inventario

## Descripción:
El siguiente proyecto esta desarrollado utilizando el Framework Symfony en su versión más reciente (4.1).

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
documentar cada endpoint. Con esto sería posible exponer una interfaz web para poder tener acceso a los endpoints disponible y su
respectiva documentación.

## Instrucciones de Configuración
- Nos situamos en la raiz del proyecto y ejecutamos:

```
~ composer install
```

y luego

```
~ npm install -g json-server
```

- Posteriormente, en una terminal iniciamos el servidor para exponer un fake api para los datos.

```
~ json-server --watch public/db.json
```

- Y en otra instancia de nuestra terminal, ejecutamos:

```
~ php bin/console server:run
```

Por defecto, nuestro fake api para los datos debe estar ejecutandose sobre la ruta: http://localhost:3000 y
el servidor del API como tal del sistema de inventario en http:127.0.0.1:8000. Son las rutas configuradas en el
fichero .env como parte de la configuración del sistema hecho en symfony.

## Aclaratoria de Implementación
Debido a los requerimientos del test, y el tiempo de implementación, veran en el código cosas que fueron 
implementadas a posta en pro de hacer el test funcional pero que en un entorno real no se llevarían a cabo de la 
misma manera obviamente. Un ejemplo de esto es el uso de un fake api server para el almacenamiento y consulta de los datos.

## Postman Collections
He exportado mi colección de postman con los endpoints definidos para su fácil visualización. Para descargar la colección
click
