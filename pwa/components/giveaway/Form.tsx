import { FunctionComponent, useState } from "react";
import Link from "next/link";
import { useRouter } from "next/router";
import { ErrorMessage, Formik } from "formik";
import { fetch } from "../../utils/dataAccess";
import { GiveAway } from "../../types/GiveAway";

interface Props {
  giveaway?: GiveAway;
}

export const Form: FunctionComponent<Props> = ({ giveaway }) => {
  const [error, setError] = useState(null);
  const router = useRouter();

  const handleDelete = async () => {
    if (!window.confirm("Are you sure you want to delete this item?")) return;

    try {
      await fetch(giveaway["@id"], { method: "DELETE" });
      router.push("/give_aways");
    } catch (error) {
      setError(`Error when deleting the resource: ${error}`);
      console.error(error);
    }
  };

  return (
    <div>
      <h1>
        {giveaway ? `Edit GiveAway ${giveaway["@id"]}` : `Create GiveAway`}
      </h1>
      <Formik
        initialValues={giveaway ? { ...giveaway } : new GiveAway()}
        validate={(values) => {
          const errors = {};
          // add your validation logic here
          return errors;
        }}
        onSubmit={async (values, { setSubmitting, setStatus, setErrors }) => {
          const isCreation = !values["@id"];
          try {
            await fetch(isCreation ? "/give_aways" : values["@id"], {
              method: isCreation ? "POST" : "PUT",
              body: JSON.stringify(values),
            });
            setStatus({
              isValid: true,
              msg: `Element ${isCreation ? "created" : "updated"}.`,
            });
            router.push("/give_aways");
          } catch (error) {
            setStatus({
              isValid: false,
              msg: `${error.defaultErrorMsg}`,
            });
            setErrors(error.fields);
          }
          setSubmitting(false);
        }}
      >
        {({
          values,
          status,
          errors,
          touched,
          handleChange,
          handleBlur,
          handleSubmit,
          isSubmitting,
        }) => (
          <form onSubmit={handleSubmit}>
            <div className="form-group">
              <label className="form-control-label" htmlFor="_date">
                date
              </label>
              <input
                name="date"
                id="_date"
                value={values.date ?? ""}
                type="text"
                placeholder=""
                className={`form-control${
                  errors.date && touched.date ? " is-invalid" : ""
                }`}
                aria-invalid={errors.date && touched.date}
                onChange={handleChange}
                onBlur={handleBlur}
              />
            </div>
            <ErrorMessage className="text-danger" component="div" name="date" />
            <div className="form-group">
              <label className="form-control-label" htmlFor="_winner">
                winner
              </label>
              <input
                name="winner"
                id="_winner"
                value={values.winner ?? ""}
                type="text"
                placeholder=""
                className={`form-control${
                  errors.winner && touched.winner ? " is-invalid" : ""
                }`}
                aria-invalid={errors.winner && touched.winner}
                onChange={handleChange}
                onBlur={handleBlur}
              />
            </div>
            <ErrorMessage
              className="text-danger"
              component="div"
              name="winner"
            />

            {status && status.msg && (
              <div
                className={`alert ${
                  status.isValid ? "alert-success" : "alert-danger"
                }`}
                role="alert"
              >
                {status.msg}
              </div>
            )}

            <button
              type="submit"
              className="btn btn-success"
              disabled={isSubmitting}
            >
              Submit
            </button>
          </form>
        )}
      </Formik>
      <Link href="/give_aways">
        <a className="btn btn-primary">Back to list</a>
      </Link>
      {giveaway && (
        <button className="btn btn-danger" onClick={handleDelete}>
          <a>Delete</a>
        </button>
      )}
    </div>
  );
};
