export class User {
    id: string;
    nom: string;
    prenom: string;
    mail: string;
   
    constructor(id: string, nom: string, prenom: string, mail: string) {
      this.id = id;
      this.nom = nom;
      this.prenom = prenom;
      this.mail = mail;
    }
   }