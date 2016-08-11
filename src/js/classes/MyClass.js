import raf from 'raf'

class MyClass {
  constructor() {
    this.runtime()
  }

  runtime = () => {
    raf(this.runtime)
  }

}

export default MyClass
