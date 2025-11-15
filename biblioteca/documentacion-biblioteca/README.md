**DOCUMENTACIÓN DEL SISTEMA DE GESTIÓN DE BIBLIOTECA.**


**1. ANÁLISIS DE REQUERIMIENTOS.**

**1.1 Requerimientos Funcionales.**


Módulo de Autenticación:


- RF01: El sistema debe permitir el registro de nuevos usuarios.

- RF02: El sistema debe validar formato de nombres (inicio con mayúscula, solo letras).

- RF03: El sistema debe validar dominios de email (gmail.com, hotmail.com, outlook.com, yahoo.com).

- RF04: El sistema debe permitir el inicio de sesión de usuarios registrados.

- RF05: El sistema debe mantener sesiones de usuario activas.


Módulo de Gestión de Libros:


- RF06: El sistema debe permitir crear nuevos libros.

- RF07: El sistema debe permitir listar todos los libros.

- RF08: El sistema debe permitir editar información de libros existentes.

- RF09: El sistema debe permitir eliminar libros.

- RF10: El sistema debe mostrar detalles completos de cada libro.


Módulo de Gestión de Autores:


- RF11: El sistema debe permitir crear nuevos autores.

- RF12: El sistema debe permitir listar todos los autores.

- RF13: El sistema debe permitir editar información de autores.

- RF14: El sistema debe permitir eliminar autores.

- RF15: El sistema debe mostrar detalles de cada autor.


Módulo de Gestión de Préstamos:


- RF16: El sistema debe permitir registrar nuevos préstamos.

- RF17: El sistema debe permitir listar todos los préstamos.

- RF18: El sistema debe permitir registrar devoluciones de libros.

- RF19: El sistema debe mostrar detalles completos de cada préstamo.

- RF20: El sistema debe actualizar disponibilidad de libros automáticamente.


Módulo de Dashboard:


- RF21: El sistema debe mostrar estadísticas generales.

- RF22: El sistema debe proporcionar acceso rápido a funciones principales.


**1.2 Requerimientos No Funcionales.**


Usabilidad:


- RNF01: Interfaz simple e intuitiva sin elementos complejos.

- RNF02: Navegación consistente en todas las vistas.

- RNF03: Mensajes de confirmación para acciones destructivas.


Rendimiento:


- RNF04: Tiempo de respuesta menor a 2 segundos para operaciones CRUD.

- RNF05: Capacidad para manejar hasta 1000 registros por tabla.


Seguridad:


- RNF06: Contraseñas almacenadas con hash seguro (password_hash).

- RNF07: Validación de entrada de datos en servidor.

- RNF08: Protección contra SQL injection usando prepared statements.

- RNF09: Control de acceso a rutas protegidas.


Mantenibilidad:


- RNF10: Código bien documentado y estructurado.

- RNF11: Arquitectura MVC para separación de concerns.

- RNF12: Uso de namespaces y autoloader personalizado.


Compatibilidad:


- RNF13: Funcionamiento con PHP 7.4+.

- RNF14: Compatibilidad con MySQL 5.7+.

- RNF15: Sin dependencias externas (sin Composer).


**2. NORMALIZACIÓN DE BASE DE DATOS.**

**2.1 Primera Forma Normal (1FN).**


Objetivo: Eliminar grupos repetitivos y asegurar atomicidad.

Logros:


- Cada tabla tiene una clave primaria única.

- Todos los atributos contienen valores atómicos.

- No hay grupos repetitivos de datos.

- Cada campo contiene un solo valor.

ejemplo:

- Cumple 1FN - Cada campo es atómico:

users (id, username, email, password, created_at)
authors (id, name, created_at)
books (id, title, author_id, isbn, available, created_at)
loans (id, user_id, book_id, loan_date, return_date, status, created_at)


**2.2 Segunda Forma Normal (2FN).**


Objetivo: Eliminar dependencias parciales.

Logros:


- Todas las tablas están en 1FN.

- Todos los atributos no clave dependen de toda la clave primaria.

- No hay dependencias parciales.


Análisis:


- Tabla loans: Todos los campos (user_id, book_id, loan_date, return_date, status) dependen completamente de la clave primaria id

- Tabla books: Todos los campos (title, author_id, isbn, available) dependen completamente de id

Las claves foráneas mantienen las relaciones sin crear dependencias parciales


**2.3 Tercera Forma Normal (3FN).**


Objetivo: Eliminar dependencias transitivas.

Logros:


- Todas las tablas están en 2FN.

- No hay dependencias transitivas (atributos que dependen de otros atributos no clave).

- Cada atributo no clave depende directamente de la clave primaria.


Análisis:


Tabla books:

title depende directamente de id 

author_id depende directamente de id 

isbn depende directamente de id 

available depende directamente de id 


Tabla loans:

user_id depende directamente de id 

book_id depende directamente de id 

loan_date depende directamente de id 

return_date depende directamente de id 

status depende directamente de id 


**2.4 Esquema Final Normalizado.**


-- Usuarios del sistema
users (id PK, username, email, password, created_at)

-- Autores de libros  
authors (id PK, name, created_at)

-- Libros con referencia a autores
books (id PK, title, author_id FK, isbn, available, created_at)

-- Préstamos con referencias a usuarios y libros
loans (id PK, user_id FK, book_id FK, loan_date, return_date, status, created_at)


**3. LÓGICA DE NEGOCIO.**

**3.1 Reglas de Negocio Principales.**


Validación de Usuarios:


- Los nombres de usuario deben comenzar con mayúscula y contener solo letras.

- Los emails deben tener dominios válidos (gmail.com, hotmail.com, outlook.com, yahoo.com).

- Las contraseñas deben tener mínimo 6 caracteres.

- No pueden existir dos usuarios con el mismo email o username.


Gestión de Libros:


- Un libro debe tener un autor existente.

- El ISBN es opcional pero debe ser único si se proporciona.

- La disponibilidad se actualiza automáticamente al realizar préstamos.


Gestión de Préstamos:


- Solo se pueden prestar libros disponibles.

- Un usuario puede tener múltiples préstamos activos.

- La devolución de un libro lo marca como disponible automáticamente.

- Los préstamos tienen estados: 'active' o 'returned'.


Integridad Referencial:


- No se puede eliminar un autor que tenga libros asociados.

- No se puede eliminar un usuario con préstamos activos.

- No se puede eliminar un libro con préstamos asociados.


**3.2 Flujos de Trabajo.**


Flujo de Préstamo:


- Verificar que el libro esté disponible.

- Registrar préstamo con estado 'active'.

- Actualizar disponibilidad del libro a false.

- Asociar préstamo con usuario autenticado.


Flujo de Devolución:


- Buscar préstamo activo

- Actualizar fecha de devolución

- Cambiar estado a 'returned'

- Actualizar disponibilidad del libro a true


**4. ARQUITECTURA DEL SISTEMA.**

**4.1 Patrón MVC Implementado.**


Modelos (models/):


- User.php: Gestión de usuarios y autenticación.

- Book.php: Operaciones CRUD de libros.

- Author.php: Gestión de autores.

- Loan.php: Administración de préstamos.


Vistas (views/):


- Estructura organizada por módulos.

- HTML básico sin estilos CSS.

- Separación de header y contenido.

- Manejo de mensajes de éxito/error.


Controladores (controllers/):


- AuthController.php: Autenticación y registro.

- BookController.php: Gestión de libros.

- AuthorController.php: Gestión de autores.

- LoanController.php: Gestión de préstamos.


**4.2 Configuración y Autoloading.**


Database.php:


- Creación automática de base de datos y tablas.

- Configuración centralizada de conexión PDO.

- Manejo de errores de conexión.


Autoloader Personalizado:


- Carga automática de clases sin Composer.

- Soporte para namespaces.

- Mapeo de namespaces a directorios.


**5. CONSIDERACIONES TÉCNICAS.**

**5.1 Seguridad Implementada.**


- Hash de contraseñas: Uso de password_hash() y password_verify().

- Prepared statements: Prevención de SQL injection.

- Validación de entrada: Filtrado y saneamiento de datos.

- Control de sesiones: Protección de rutas privadas.

- Escape de output: Uso de htmlspecialchars() en vistas.


**5.2 Manejo de Errores.**


- Mensajes de error amigables para usuarios.

- Logs de errores técnicos (podrían implementarse).

- Validación tanto en frontend como backend.

- Manejo de excepciones de base de datos.


**5.3 Escalabilidad.**


- Arquitectura modular que permite agregar nuevos features.

- Base de datos normalizada para optimizar consultas.

- Separación de concerns para mantenimiento fácil.

- Código documentado para futuras extensiones.


**6. LIMITACIONES Y MEJORAS FUTURAS.**

**6.1 Limitaciones Actuales.**


- Interfaz muy básica sin estilos.

- No hay paginación para listas largas.

- No hay búsqueda o filtros avanzados.

- No hay roles de usuario (todos los usuarios tienen mismos permisos).


**6.2 Posibles Mejoras.**


- Implementar sistema de roles (admin, usuario regular).

- Agregar categorías de libros.

- Implementar reservas de libros.

- Agregar reportes y estadísticas avanzadas.

- Mejorar interfaz con CSS framework.

- Implementar paginación y búsqueda.

- Agregar historial de préstamos por usuario.