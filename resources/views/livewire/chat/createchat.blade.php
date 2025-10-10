<div>
    @if(auth()->guard('patient')->check() || auth()->guard('doctor')->check())
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6 class="card-title mb-0">
                        {{ auth()->guard('patient')->check() ? 'قائمة الأطباء' : 'قائمة المرضى' }}
                    </h6>
                </div>
                <div class="card-body">
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table style="text-align: center" class="table text-md-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ auth()->guard('patient')->check() ? 'اسم الدكتور' : 'اسم المريض' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <button class="btn btn-primary" wire:loading.attr="disabled"
                                            wire:click="createConversation('{{$user->email}}')"
                                            wire:loading.class="disabled">
                                            <span wire:loading wire:target="createConversation('{{$user->email}}')" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            {{$user->name}}
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-warning" role="alert">
        يرجى تسجيل الدخول للوصول إلى المحادثات
        <a href="{{ route('selection') }}" class="alert-link">تسجيل الدخول</a>
    </div>
    @endif
</div>
