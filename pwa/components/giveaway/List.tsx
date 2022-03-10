import { FunctionComponent } from "react";
import Link from "next/link";
import ReferenceLinks from "../../components/common/ReferenceLinks";
import { GiveAway } from "../../types/GiveAway";

interface Props {
  give_aways: GiveAway[];
}

export const List: FunctionComponent<Props> = ({ give_aways }) => (
  <div>
    <h1>GiveAway List</h1>
    <Link href="/give_aways/create">
      <a className="btn btn-primary">Create</a>
    </Link>
    <table className="table table-responsive table-striped table-hover">
      <thead>
        <tr>
          <th>id</th>
          <th>date</th>
          <th>winner</th>
          <th />
        </tr>
      </thead>
      <tbody>
        {give_aways &&
          give_aways.length !== 0 &&
          give_aways.map((giveaway) => (
            <tr key={giveaway["@id"]}>
              <th scope="row">
                <ReferenceLinks items={giveaway["@id"]} type="giveaway" />
              </th>
              <td>{giveaway["date"]}</td>
              <td>
                <ReferenceLinks items={giveaway["winner"]} type="Participant" />
              </td>
              <td>
                <ReferenceLinks
                  items={giveaway["@id"]}
                  type="giveaway"
                  useIcon={true}
                />
              </td>
              <td>
                <Link href={`${giveaway["@id"]}/edit`}>
                  <a>
                    <i className="bi bi-pen" aria-hidden="true" />
                    <span className="sr-only">Edit</span>
                  </a>
                </Link>
              </td>
            </tr>
          ))}
      </tbody>
    </table>
  </div>
);
