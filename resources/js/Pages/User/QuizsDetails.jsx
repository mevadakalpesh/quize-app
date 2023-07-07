import { Link } from '@inertiajs/react';

const QuizsDetails = ({quize}) => {
  const categories = quize.category.map((category) => category.name );
  return (
     <div className="card mt-3" >
          <div className="card-body">
            <h5 className="card-title">{quize.quize_name}</h5>
            <p className="card-text">{quize.description}</p>
          </div>
          <ul className="list-group list-group-flush">
            <li className="list-group-item"><b>Expire Time :</b> {quize.expire_time} Min</li>
            <li className="list-group-item"><b>Created Time :</b> {quize.created_at}</li>
            <li className="list-group-item"><b>Total Questions :</b> {quize.questions.length}</li>
            <li className="list-group-item"><b>Quize Belongs :</b> {categories.join(", ")}</li>
            <li className="list-group-item"><b>Status :</b>{quize.quize_user_details.status}</li>
          </ul>
          <div className="card-body d-flex justify-content-between">
            <Link href={route('quizeJoin',quize.id)} className="btn btn-success">Join</Link>
            <Link href={route('quizeDecline',quize.id)} className="btn btn-danger">Decline</Link>
          </div>
        </div>
  )
}
export default QuizsDetails;