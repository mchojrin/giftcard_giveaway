export class GiveAway {
  public "@id"?: string;

  constructor(_id?: string, public date?: Date, public winner?: string) {
    this["@id"] = _id;
  }
}
