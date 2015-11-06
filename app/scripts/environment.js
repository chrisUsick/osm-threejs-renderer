'use strict'
class Environment {
  constructor(container, {nodes}) {
    this.scene = new THREE.Scene();
    this.width = container.offsetWidth;
    this.height = window.innerHeight - 10;

    this.camera = new THREE.PerspectiveCamera( 75, this.width / this.height, 1, 1000 );
    this.camera.position.y =100;

    let road = this.createRoad(nodes);
    this.road = road;
    let vert = road.geometry.vertices[2];
    console.log(road.geometry.vertices);
    // road.geometry.vertices.forEach((vert)=>{
    //   this.scene.add(this.createCube(vert))
    // });
    this.camera.lookAt(vert);
    this.scene.add(road);

    this.renderer = new THREE.WebGLRenderer();
    this.renderer.setSize( this.width, this.height );

    container.appendChild(this.renderer.domElement);

  }


  animate() {
      const self = this;
      requestAnimationFrame( this.animate.bind(this) );
      this.renderer.render( this.scene, this.camera );

  }

  /**
   * create a cube
   * @param  {Object}     the position of the cube
   * @return {THREE.Mesh} a cube
   */
  createCube(position) {
    const n = 20;
    var geometry = new THREE.BoxGeometry( n,n,n );
    // var material = new THREE.MeshBasicMaterial( { color: 0xff0000, wireframe: true } );
    var material = new THREE.MeshNormalMaterial( { wireframe:false  } );
    var mesh = new THREE.Mesh( geometry,material );
    var {x,y,z} = position;
    mesh.position.set(x,y,z);
    return mesh;
  }

  /**
   * create a road given a set of nodes
   * @param  {Array} nodes array of nodes
   */
  createRoad(nodes) {
    let roadGeom = new THREE.Geometry();
    let vecs = this.nodesToVectors(nodes);
    let normalPrevious = new THREE.Vector3();
    // create vertices for each node
    vecs.forEach( (node, i) => {
      // let faceGeom = new THREE.Geometry();
      let normal = new THREE.Vector3();
      let nextNode = vecs[i+1];
      if (nextNode) {
        normal.subVectors(nextNode, node);
        normal.set(normal.z, normal.y, -normal.x).normalize();
        normalPrevious.copy(normal);
      } else {
        normal.copy(normalPrevious);
      }
      let normalNegative = normal.clone();
      normal.multiplyScalar(10);
      let v1 = node.clone().add(normal);
      normalNegative.multiplyScalar(-10);
      let v2 = node.clone().add(normalNegative);
      roadGeom.vertices.push(v1, v2);
    });

    // add faces
    this.addFaces(roadGeom);

    // THREE.GeometryUtils.center(roadGeom);
    // roadGeom.center();
    //create mess
    var material = new THREE.MeshNormalMaterial( { wireframe:false  } );
    material.side = THREE.DoubleSide;
    var mesh = new THREE.Mesh( roadGeom,material );
    return mesh;
  }

  addFaces(geom) {
    let verts = geom.vertices;
    for (var i = 0; i < verts.length-1-3; i+=2) {
      geom.faces.push(
        new THREE.Face3(i, i+1, i+2, new THREE.Vector3(0,1,0)),
        new THREE.Face3(i+1, i+2, i+3, new THREE.Vector3(0,1,0)));
    }
  }

  /**
   * turn basic nodes into three.Vectors
   * @param  {Array} nodes       array of basic nodes
   * @return {THREE.Vector[]}    array of vectors
   */
  nodesToVectors(nodes){
    return nodes.map((node) => new THREE.Vector3(parseFloat(node.x), 0,parseFloat(node.z)));
  }
}
