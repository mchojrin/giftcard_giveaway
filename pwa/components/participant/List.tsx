import { FunctionComponent } from "react";
import Link from "next/link";
import ReferenceLinks from "../../components/common/ReferenceLinks";
import { Participant } from "../../types/Participant";

interface Props {
  participants: Participant[];
}

export const List: FunctionComponent<Props> = ({ participants }) => (
  <div>
    <h1>Participant List</h1>
    <Link href="/participants/create">
      <a className="btn btn-primary">Create</a>
    </Link>
    <table className="table table-responsive table-striped table-hover">
      <thead>
        <tr>
          <th>id</th>
          <th>name</th>
          <th>email</th>
          <th />
        </tr>
      </thead>
      <tbody>
        {participants &&
          participants.length !== 0 &&
          participants.map((participant) => (
            <tr key={participant["@id"]}>
              <th scope="row">
                <ReferenceLinks items={participant["@id"]} type="participant" />
              </th>
              <td>{participant["name"]}</td>
              <td>{participant["email"]}</td>
              <td>
                <ReferenceLinks
                  items={participant["@id"]}
                  type="participant"
                  useIcon={true}
                />
              </td>
              <td>
                <Link href={`${participant["@id"]}/edit`}>
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
