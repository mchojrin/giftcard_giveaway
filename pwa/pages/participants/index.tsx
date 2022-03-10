import { NextComponentType, NextPageContext } from "next";
import { List } from "../../components/participant/List";
import { PagedCollection } from "../../types/Collection";
import { Participant } from "../../types/Participant";
import { fetch } from "../../utils/dataAccess";
import Head from "next/head";

interface Props {
  collection: PagedCollection<Participant>;
}

const Page: NextComponentType<NextPageContext, Props, Props> = ({
  collection,
}) => (
  <div>
    <div>
      <Head>
        <title>Participant List</title>
      </Head>
    </div>
    <List participants={collection["hydra:member"]} />
  </div>
);

Page.getInitialProps = async () => {
  const collection = await fetch("/participants");

  return { collection };
};

export default Page;
