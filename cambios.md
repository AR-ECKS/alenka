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