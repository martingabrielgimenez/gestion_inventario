# Prueba técnica sistema de Gestión de Inventario, Martín Gimenez

Este sistema web permite gestionar inventario de productos, registrarse, iniciar sesión, editar y administrar productos en una base de datos.

## Características principales

- Gestión de productos (crear, leer, editar, eliminar).
- Autenticación de usuarios con roles (admin y usuario).
- Panel de control para administradores.
- Visualización de productos con bajo stock y productos más vendidos.
- Seguridad mediante manejo de roles y validación de datos.


1. Usar archivo SQL en la base de datos:
    - Importa el archivo `inventario.sql` que se encuentra en la carpeta raíz del proyecto en un gestor de bases de datos.

2. Acceso a la base de datos:
    - Abrir el archivo `config/db.php` y ver o actualizar las credenciales de la base de datos.

3. Iniciar el servidor:
   `

5. Acceder al sistema en tu navegador:
    ```
    http://localhost:8000
    ```

## Uso

1. Registra un nuevo usuario en la ruta (http://localhost/inventario/src/views/auth/register.php) ya sea como usuario común o admin. 

2. Una vez hecho esto, nos va a redireccionar al Login (http://localhost/inventario/src/views/auth/login.php).

3. Tanto usuarios comunes como los administradores van a ver ver el Panel de Control (http://localhost/inventario/src/views/dashboard/index.php) que muestra las estadísticas generales, detalles como productos con bajo stock (los que tienen menos de 10 productos en stock), productos más vendidos y por último el enlace a la Lista de productos.

4. En la lista de Productos (http://localhost/inventario/src/views/productos/index.php), se puede ver un CRUD que muestra el ID del producto, su nombre, categoría, stock, precio y las acciones de editar y eliminar. Debajo del CRUD van a estar los enlaces para crear un nuevo producto y para volver al dashboard.

5. Los usuarios comunes no van a tener permiso para editar esta información, ya que al hacer click en el botón, el sistema va a mostrar una página de acceso denegado con enlaces para volver al Panel de control (dashboard).

6. Los administradores van a poder crear un nuevo Producto, haciendo click en 'Crear nuevo Producto', el sistema va a redireccionar a (http://localhost/inventario/src/views/productos/create.php), donde va a poder añadir uno nuevo pudiendo elegir su Nombre, Categoría, elegir su cantidad de Stock y también su precio.  

6. Una vez hecho esto, el sistema redirecciona nuevamente a la Lista y ya va a poder ver su producto añadido al crud.
