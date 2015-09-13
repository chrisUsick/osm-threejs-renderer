# schemas
from [](https://git.openstreetmap.org/rails.git/blob/HEAD:/db/structure.sql)
## nodes
CREATE TABLE nodes (
     node_id bigint NOT NULL,
     latitude decimal(8,6) NOT NULL,
     longitude decimal(9,6) NOT NULL,
     visible boolean NOT NULL,
);

## ways
CREATE TABLE ways (
    way_id bigint DEFAULT 0 NOT NULL,
    visible boolean DEFAULT true NOT NULL,
);

## way_nodes
CREATE TABLE way_nodes (
    way_id bigint NOT NULL,
    node_id bigint NOT NULL,
    -- order of nodes in a way
    sequence_id bigint NOT NULL
);
