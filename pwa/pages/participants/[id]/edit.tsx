import { NextComponentType, NextPageContext } from "next";
import { Form } from "../../../components/participant/Form";
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
          <title>
            {participant && `Edit Participant ${participant["@id"]}`}
          </title>
        </Head>
      </div>
      <Form participant={participant} />
    </div>
  );
};

Page.getInitialProps = async ({ asPath }: NextPageContext) => {
  const participant = await fetch(asPath.replace("/edit", ""));

  return { participant };
};

export default Page;
