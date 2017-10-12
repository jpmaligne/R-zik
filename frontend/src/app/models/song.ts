export class Song {
    id: string;
    title: string;
    description: string;
    photo: string;
    artist: string;
    explicitContent: string;
    downloadAuthorization: string;
    createdAt: string;
    updatedAt: string;
    length: string;
    typeId: string;

    constructor(id: string, title: string, description: string, photo: string,
                artist: string, explicitContent: string, downloadAuthorization: string,
                createdAt: string, updatedAt: string, length: string, typeId: string) {
      this.id = id;
      this.title = title;
      this.description = description;
      this.photo = photo;
      this.artist = artist;
      this.explicitContent = explicitContent;
      this.downloadAuthorization = downloadAuthorization;
      this.createdAt = createdAt;
      this.updatedAt =updatedAt;
      this.length = length;
      this.typeId = typeId;
    }
   }