# schemas
from [](https://git.openstreetmap.org/rails.git/blob/HEAD:/db/structure.sql)

## nodes

```sql
-- mysql, old
CREATE TABLE nodes (
     node_id bigint NOT NULL,
     latitude decimal(8,6) NOT NULL,
     longitude decimal(9,6) NOT NULL,
     visible boolean NOT NULL,
);
```

```sql
CREATE TABLE nodes (
     node_id bigint primary key NOT NULL,
     visible boolean NOT NULL,
     coords POINT(4326)
);
```

## ways

```sql
-- mysql, old
CREATE TABLE ways (
    way_id bigint DEFAULT 0 NOT NULL,
    visible boolean DEFAULT true NOT NULL,
);
```

```sql
CREATE TABLE ways (
    way_id bigint primary key NOT NULL,
    visible boolean DEFAULT true NOT NULL,
);
```

## way_nodes

```sql
-- mysql, old
CREATE TABLE way_nodes (
    way_id bigint NOT NULL,
    node_id bigint NOT NULL,
    -- order of nodes in a way
    sequence_id bigint NOT NULL
);
```

```sql
CREATE TABLE way_nodes (
    way_id bigint NOT NULL,
    node_id bigint NOT NULL,
    -- order of nodes in a way
    sequence_id bigint NOT NULL
    add primary key (way_id, node_id, sequence_id)
);
```

# spacial search procedure

```sql
CREATE FUNCTION haversine(
        lat1 FLOAT, lon1 FLOAT,
        lat2 FLOAT, lon2 FLOAT
     ) RETURNS FLOAT
    NO SQL DETERMINISTIC
    COMMENT 'Returns the distance in degrees on the Earth
             between two known points of latitude and longitude'
BEGIN
    RETURN DEGREES(ACOS(
              COS(RADIANS(lat1)) *
              COS(RADIANS(lat2)) *
              COS(RADIANS(lon2) - RADIANS(lon1)) +
              SIN(RADIANS(lat1)) * SIN(RADIANS(lat2))
            ));
END$$
```

# spatial queries
## distance from center

```sql
select node_id, ST_distance(
    ST_MakePoint(0,0),
    ST_MakePoint(lat, lon)
)distance
from
    (SELECT node_id, (ST_X(coords) - 49.92797515)*110574.61087757687 AS lat, (ST_Y(coords)- -97.06265335)*111302.61697430261 as lon
    FROM nodes) as s
order by distance
;
```

## diagonal distance

```sql
select ST_distance(
    ST_MakePoint(nex,ney),
    ST_MakePoint(swx, swy)
)distance
from
    (SELECT MIN(ST_X(coords)) * 110574.61087757687 as nex,  MAX(ST_Y(coords)) * 111302.61697430261 as ney,
        MAX(ST_X(coords)) * 110574.61087757687 as swx,  MIN(ST_Y(coords))  * 111302.61697430261 as swy
    FROM nodes) as s
order by distance
;
```

## compare normal distance to center to lat/lon distance to center
`N` is the center point

```sql
SELECT
  nodes.visible,
  ST_distance(St_setSrid(ST_MakePoint(n.lat,n.lon), 4326), coords) distance1,
  st_distance(nodes.normal_coords, ST_POINT(0,0)) distance2,
  dims.width1/ST_distance(St_setSrid(ST_MakePoint(n.lat,n.lon), 4326), coords) ratio1,
  dims.width2/st_distance(nodes.normal_coords, ST_POINT(0,0)) ratio2,
  nodes.node_id
FROM
  public.nodes, (select max(st_x(coords)) - min(st_y(coords)) width1,
            max(st_x(normal_coords)) - min(st_y(normal_coords)) width2 from nodes) dims
          , (SELECT (MAX(ST_X(coords))+MIN(ST_X(coords)))/2 AS lat, (MAX(ST_Y(coords))+MIN(ST_Y(coords)))/2 as lon
            FROM nodes) N
  order by distance2;
```

## create normal_coords with dynamic center

```sql
update nodes
set normal_coords = ST_MakePoint((ST_X(coords) - lat)*110574.61087757687, (ST_Y(coords)- lon)*111302.61697430261)
-- lat, lon are center points
from  (SELECT (MAX(ST_X(coords))+MIN(ST_X(coords)))/2 AS lat, (MAX(ST_Y(coords))+MIN(ST_Y(coords)))/2 as lon
FROM nodes) N;
```

# Application structure
## MVP
load a way and draw it into threejs Drawing the way will be done by actual distance conversion, where the coordinate (0,0,0) in Three is the center of the map.

### draw nodes
1. get nodes from a way
2. create cube
3. offset cube based on offset from center
