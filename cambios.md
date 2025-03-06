# CAMBIOS DE TABLAS Y/O NOTAS ALENKA

1. Se agrego a la tabla **despachos** una columna de:

| nombre | tipo | nulo |
|---|---|---|
| sabor | VARCHAR(255) | no |

2. Nueva tabla llamada **pre_salida_molino**

| nombre | tipo | nulo | pk | fk | comentario |
|---|---|---|---|---|---|
| id | INT UNSIGNED |  | si | |
| codigo | VARCHAR(255) | si |
| fecha | DATE | si | |
| turno | VARCHAR(255) | SI | | | puede ser MAÑANA o TARDE 
| id_encargado | INT UNSIGNED | | | si | es el que recibe la mezcla a  **users**
| proceso_id | INT UNSIGNED | si | | si | a la tabla **procesos**
| observacion | VARCHAR(255) | si | | | observaciones de entrega
| baldes | INT |  | | | la cantidad de baldes que recibe
| cantidad | INT |  | | | la cantida dek producto recibido en kilogramos
| id_user | INT UNSIGNED |  | | si | usuario que la ultima vez hizo cambios
| estado | TINYINT | | | | puede ser 1 o 0


3. Incluir nueva tabla llamada **proceso_preparacion** 

| nombre | tipo | nulo | pk | fk | comentario |
|---|---|---|---|---|---|
| id | INT UNSIGNED |  | si | |
| codigo | VARCHAR(255) | si |
| fecha | DATE | si | |
| total_kg | FLOAT(4) | si | | | 
| disponible_kg | FLOAT(4) | si | | |  
| despacho_id | INT UNSIGNED | si | | si | a la tabla **despachos**
| observacion | VARCHAR(255) | si | | | observaciones de entrega
| id_user | INT UNSIGNED |  | | si | usuario que la ultima vez hizo cambios (encargado)
| estado | TINYINT | | | | puede ser 1 o 0

4. Incluir una nuva tabla llamada **detalle_proceso_preparacion** dependiente de **proceso_preparacion**

| nombre | tipo | nulo | pk | fk | comentario |
|---|---|---|---|---|---|
| id | INT UNSIGNED |  | si | |
| kg_balde | FLOAT(4) | si | | | 
| nro_balde | INT UNSIGNED | si | | |  
| fecha | DATE | si | |
| proceso_preparacion_id | INT UNSIGNED | si | | si | a la tabla **despachos**
| observacion | VARCHAR(255) | si | | | observaciones de entrega
| id_user | INT UNSIGNED |  | | si | usuario que la ultima vez hizo cambios (encargado)
| estado | TINYINT | | | | puede ser 1 o 0

5. Incluir una nueva tabla llamada **maquinas**

| nombre | tipo | nulo | pk | fk | comentario |
|---|---|---|---|---|---|
| id | INT UNSIGNED |  | si | |
| nombre | VARCHAR(100) | si | | | 
| descripcion | VARCHAR(255) | si | | |
| id_user | INT UNSIGNED |  | | si | usuario que la ultima vez hizo cambios (encargado)
| estado | TINYINT | | | | puede ser 1 o 0

6. Incluir una nueva tabla llamada **salidas_de_molino**

| nombre | tipo | nulo | pk | fk | comentario |
|---|---|---|---|---|---|
| id | INT UNSIGNED |  | si | |
| codigo | VARCHAR(255) | si | | crear código autogenerado
| fecha | DATE |  | |
| turno | VARCHAR(255) | SI | | | puede ser MAÑANA o TARDE 
| encargado_id | INT UNSIGNED | | | si | es el que recibe la mezcla a  **users**
| maquina_id | INT UNSIGNED | | | si | es la maquina asignadas a  **maquinas**
| sabor | VARCHAR(50) | si | | -- | crear una referencia o tener un lista de php de sabores (INT UNSIGNED)
| observacion | VARCHAR(255) | si | | | observaciones de entrega
| total_aprox | FLOAT(4) |  | | | la cantidad aproximada producto recibido en kilogramos
| id_user | INT UNSIGNED |  | | si | usuario que la ultima vez hizo cambios
| estado | TINYINT | | | | puede ser 1 o 0

7. Incluir una nueva tabla llamada **detalle_salidas_de_molino**

| nombre | tipo | nulo | pk | fk | comentario |
|---|---|---|---|---|---|
| id | INT UNSIGNED |  | si | |
| salida_de_molino_id | INT UNSIGNED | | |si | 
| detalle_proceso_preparacion_id | INT UNSIGNED | | |si | 
| id_user | INT UNSIGNED |  | | si | usuario que la ultima vez hizo cambios
| estado | TINYINT | | | | puede ser 1 o 0 |

8. A la tabla llamada **productos_envasados** se incluyo nuevas columnas

| nombre | tipo | nulo | pk | fk | comentario |
|---|---|---|---|---|---|
| balde_cambio_de_maquina_id | INT UNSIGNED | si |  | si | hace referecia a la tabla productos_envasados, en la principal sirve para añadir mas baldes y kg, en la que se hace referencia, es para descontar baldes y kg
| balde_cambio_de_maquina_baldes | FLOAT(4) | si | | | solo sirve, cuando la columna balde_cambio_de_maquina_id este asignado 
| balde_cambio_de_maquina_kg | FLOAT(4) | si | | | solo sirve, cuando la columna balde_cambio_de_maquina_id este asignado 

8. A la tabla llamada **productos_envasados** se incluyo nuevas columnas para pica

| nombre | tipo | nulo | pk | fk | comentario |
|---|---|---|---|---|---|
| para_picar | TINYINT | | | | si este es 1: entoces es para picar, si es 0: no
| para_picar_nro_de_bolsitas | INT | si | | | si 'para_picar' es 1: entonces este campo no puede ser nulo
| para_picar_kg_de_bolsitas | FLOAT(4) | si | | | si 'para_picar' es 1: entonces este campo no puede ser nulo