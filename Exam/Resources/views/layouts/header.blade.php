<div class="container-fluid behind">
<div class="row">
    <div class="col-md-12">
        <div class="card mb-2">
            <div class="card-body p-3">
                <h4 class="mb-0">Exam</h4>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-2">
            <div class="card-body p-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:white !important">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ route('exam.timetable') }}">Exam Timetable</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Reports
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('exam-reports-students.req-all')}}">Students List With All Requirements</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Settings
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('exam-type.list')}}">Exam Types</a>
                                <a class="dropdown-item" href="{{route('exam-categories.list')}}">Exam Categories</a>
                                <a class="dropdown-item" href="{{route('grade-groupes.list')}}">Grade Groupes</a>
                                <a class="dropdown-item" href="{{route('grades.list')}}">Grades</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            </div>
        </div>
    </div>
</div>
</div>

