# schemas
from [](https://git.openstreetmap.org/rails.git/blob/HEAD:/db/structure.sql)

## nodes

```sql
CREATE TABLE nodes (
     node_id bigint NOT NULL,
     latitude decimal(8,6) NOT NULL,
     longitude decimal(9,6) NOT NULL,
     visible boolean NOT NULL,
);
```

```sql
CREATE TABLE nodes (
     node_id int primary key NOT NULL,
     visible boolean NOT NULL,
     coords POINT(4326)
);
```

## ways

```sql
CREATE TABLE ways (
    way_id bigint DEFAULT 0 NOT NULL,
    visible boolean DEFAULT true NOT NULL,
);
```

## way_nodes

```sql
CREATE TABLE way_nodes (
    way_id bigint NOT NULL,
    node_id bigint NOT NULL,
    -- order of nodes in a way
    sequence_id bigint NOT NULL
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

# Application structure
## MVP
load a way and draw it into threejs Drawing the way will be done by actual distance conversion, where the coordinate (0,0,0) in Three is the center of the map.

### draw nodes
1. get nodes from a way
2. create cube
3. offset cube based on offset from center
