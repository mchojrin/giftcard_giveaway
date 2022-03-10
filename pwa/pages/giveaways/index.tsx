import { NextComponentType, NextPageContext } from "next";
import { List } from "../../components/giveaway/List";
import { PagedCollection } from "../../types/Collection";
import { GiveAway } from "../../types/GiveAway";
import { fetch } from "../../utils/dataAccess";
import Head from "next/head";

interface Props {
  collection: PagedCollection<GiveAway>;
}

const Page: NextComponentType<NextPageContext, Props, Props> = ({
  collection,
}) => (
  <div>
    <div>
      <Head>
        <title>GiveAway List</title>
      </Head>
    </div>
    <List give_aways={collection["hydra:member"]} />
  </div>
);

Page.getInitialProps = async () => {
  const collection = await fetch("/give_aways");

  return { collection };
};

export default Page;
