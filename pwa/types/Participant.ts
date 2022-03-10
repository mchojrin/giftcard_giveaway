export class Participant {
  public "@id"?: string;

  constructor(_id?: string, public name?: string, public email?: string) {
    this["@id"] = _id;
  }
}
