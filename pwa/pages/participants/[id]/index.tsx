import { NextComponentType, NextPageContext } from "next";
import { Show } from "../../../components/participant/Show";
import { Participant } from "../../../types/Participant";
import { fetch } from "../../../utils/dataAccess";
import Head from "next/head";

interface Props {
  participant: Participant;
}

const Page: NextComponentType<NextPageContext, Props, Props> = ({
  participant,
}) => {
  return (
    <div>
      <div>
        <Head>
          <title>{`Show Participant ${participant["@id"]}`}</title>
        </Head>
      </div>
      <Show participant={participant} />
    </div>
  );
};

Page.getInitialProps = async ({ asPath }: NextPageContext) => {
  const participant = await fetch(asPath);

  return { participant };
};

export default Page;
