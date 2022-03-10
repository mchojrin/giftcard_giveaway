import { NextComponentType, NextPageContext } from "next";
import { Form } from "../../components/participant/Form";
import Head from "next/head";

const Page: NextComponentType<NextPageContext> = () => (
  <div>
    <div>
      <Head>
        <title>Create Participant </title>
      </Head>
    </div>
    <Form />
  </div>
);

export default Page;
