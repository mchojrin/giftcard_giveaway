import { NextComponentType, NextPageContext } from "next";
import { Form } from "../../../components/giveaway/Form";
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
          <title>{giveaway && `Edit GiveAway ${giveaway["@id"]}`}</title>
        </Head>
      </div>
      <Form giveaway={giveaway} />
    </div>
  );
};

Page.getInitialProps = async ({ asPath }: NextPageContext) => {
  const giveaway = await fetch(asPath.replace("/edit", ""));

  return { giveaway };
};

export default Page;
