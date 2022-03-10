import { NextComponentType, NextPageContext } from "next";
import { Show } from "../../../components/giveaway/Show";
import { GiveAway } from "../../../types/GiveAway";
import { fetch } from "../../../utils/dataAccess";
import Head from "next/head";

interface Props {
  giveaway: GiveAway;
}

const Page: NextComponentType<NextPageContext, Props, Props> = ({
  giveaway,
}) => {
  return (
    <div>
      <div>
        <Head>
          <title>{`Show GiveAway ${giveaway["@id"]}`}</title>
        </Head>
      </div>
      <Show giveaway={giveaway} />
    </div>
  );
};

Page.getInitialProps = async ({ asPath }: NextPageContext) => {
  const giveaway = await fetch(asPath);

  return { giveaway };
};

export default Page;
