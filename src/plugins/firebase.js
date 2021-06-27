import * as firebase from 'firebase'
import 'firebase/database'

const config = {
  apiKey: 'AIzaSyCNAIssdMXIrUgIXiYGvLct2p0oLSb0coU',
  authDomain: 'e-office-a505b.firebaseapp.com',
  projectId: 'e-office-a505b',
  storageBucket: 'e-office-a505b.appspot.com',
  messagingSenderId: '1014162713735',
  appId: '1:1014162713735:web:e161f9ba9d8c646ac65c22'
}

firebase.initializeApp(config)

export default firebase.database()
