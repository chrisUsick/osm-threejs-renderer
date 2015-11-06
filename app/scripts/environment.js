'use strict'
class Environment {
  constructor(container, {nodes}) {
    this.scene = new THREE.Scene();
    this.width = container.offsetWidth;
    this.height = window.innerHeight - 10;

    this.camera = new THREE.PerspectiveCamera( 75, this.width / this.height, 1, 10000 );
    this.camera.position.y = 250;

    this.camera.lookAt(this.camera.up.negate());


    for (var node of nodes) {
      node.y = 0;
      let cube = this.createCube(node);
      this.scene.add(cube);
    }

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
    var geometry = new THREE.BoxGeometry( 2, 2, 2 );
    var material = new THREE.MeshBasicMaterial( { color: 0xff0000, wireframe: true } );
    var mesh = new THREE.Mesh( geometry,material );
    var {x,y,z} = position;
    mesh.position.set(x,y,z);
    return mesh;
  }
}
