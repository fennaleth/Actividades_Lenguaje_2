**Simulación de Entrevista. Recolección de Requerimientos.**

Contexto del cliente:

La empresa Creativa360 es una agencia de marketing digital que gestiona campañas de contenido para múltiples clientes. Necesitan una plataforma interna para organizar publicaciones, comentarios de clientes, archivos multimedia y etiquetas temáticas.

Entrevista con el Gerente de Proyectos:

-Analista: ¿Cuál es el objetivo principal del sistema que desean implementar?
-Cliente: Queremos una plataforma donde nuestros redactores puedan crear publicaciones, los clientes puedan dejar comentarios, y podamos organizar todo con etiquetas y archivos multimedia.

-Analista: ¿Qué tipo de usuarios interactuarán con el sistema?
-Cliente: Principalmente redactores, diseñadores y clientes. Cada uno debe tener un perfil con información básica.

-Analista: ¿Cómo gestionan actualmente las publicaciones y los comentarios?
-Cliente: Usamos hojas de cálculo y correos. Es un caos. Queremos que cada publicación tenga comentarios asociados y que podamos adjuntar imágenes o videos.

-Analista: ¿Desean categorizar o etiquetar las publicaciones?
-Cliente: Sí, usamos etiquetas como “branding”, “SEO”, “redes sociales”, etc. Una publicación puede tener varias etiquetas.

-Analista: ¿Los archivos multimedia pueden estar en publicaciones y comentarios?
-Cliente: Exacto. A veces los clientes suben imágenes en los comentarios, y nosotros también en las publicaciones.

**Traducción de Requerimientos al Modelo de Datos.**

Tablas y Propiedades:

-Users -> Campos: ID_user(int), name(varchar), email(varchar). Representa a cada usuario del sistema.
-Profiles -> Campos: ID_profile(int), FK_user(int), bio(text), avatar_url(varchar). Información extendida del usuario.
-Posts -> ID_post(int), FK_user(int), title(varchar), content(text), created_at(timestamp). Publicaciones creadas por usuarios.
-Comments -> Campos: ID_comment(int), FK_post(int), FK_user(int), content(text), created_at(timestamp). Comentarios de usuarios sobre publicaciones.
-Tags -> Campos: ID_tag(int), name(varchar). Etiquetas temáticas reutilizables.
-Post_Tags -> Campos: FK_post(int), FK_tag(int). Relación entre publicaciones y etiquetas.
-Media -> Campos: ID_media(int), file_url(varchar), media_able(int), media_type(enum). Archivos multimedia asociados a publicaciones o comentarios.

**Tipos de Relaciones entre las Tablas y Justificación.**

-Users 1:1 Profiles -> Cada usuario tiene un perfil único con información adicional.
-Users 1:N Posts -> Un usuario puede crear muchas publicaciones.
-Posts 1:N Comments -> Una publicación puede tener muchos comentarios.
-Users 1:N Comments -> Un usuario puede comentar en muchas publicaciones.
-Posts N:N Tags -> Una publicación puede tener muchas etiquetas, y una etiqueta puede aplicarse a muchas publicaciones.
-Media Polimórficas con Posts o Comments -> Un archivo multimedia puede pertenecer a una publicación o a un comentario.

**Conclusión del Análisis.**

Gracias a la entrevista, se pudo identificar que el sistema debía:

-Soportar múltiples tipos de usuarios con perfiles personalizados.
-Permitir la creación y organización de publicaciones.
-Facilitar la retroalimentación mediante comentarios.
-Asociar archivos multimedia a distintos tipos de contenido.
-Clasificar publicaciones con etiquetas reutilizables.

El modelo de datos propuesto cubre todos estos requerimientos de forma escalable y normalizada, permitiendo futuras extensiones como likes, historial de edición, o notificaciones.
