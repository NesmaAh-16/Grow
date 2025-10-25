
{{-- - <!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الواجب</title>
    < <title>إضافة اختبار جديد</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon" width = "15px">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/create-quiz.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/homework-detials.css') }}" />
</head>
<body>
    <div class="page-container">
         <nav>
            <div class="nav-left">
                <a class="brand" href="{{ route('home') }}">
                    <img class="logo" src="{{ asset('assets/images/imageedit_2_6635233653.png') }}"
                        alt="شعار المنصة" />
                    <img class="brand-name" src="{{ asset('assets/images/logomwhite.png') }}" alt="Grow" />
                </a>
            </div>
            <div class="nav-menu">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fas fa-home" style="margin-left: 8px"></i>
                    الصفحة الرئيسية
                </a>
            </div>

            <div class="nav-right">
                <button class="nav-btn" title="الإشعارات">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>
                <a href="#" class="nav-btn" title="الإعدادات">
                    <i class="fas fa-cog"></i>
                </a>
                <a href="#" class="logout-btn"
                    onclick ="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>تسجيل خروج</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
                    @csrf
                </form>
            </div>
        </nav>

        <main class="main-content">
            <section class="page-header">
                <h1>تفاصيل الواجب</h1>
            </section>

            <section class="details-card">
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="detail-label">اسم الواجب</span>
                        <span class="detail-value" id="assignment-title"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">الصف</span>
                        <span class="detail-value" id="assignment-class"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">تاريخ النشر</span>
                        <span class="detail-value" id="assignment-publish-date"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">تاريخ التسليم</span>
                        <span class="detail-value" id="assignment-due-date"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">عدد الطلاب المسلّمين</span>
                        <span class="detail-value"><span class="progress-text" id="assignment-submitted-count"></span> / <span id="assignment-total-count"></span></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">المرفقات</span>
                        <ul class="attachments-list" id="assignment-attachments"></ul>
                    </div>
                </div>
            </section>

            <section class="edit-assignment-section" id="edit-assignment-section" style="display: none;">
                <h2>تعديل الواجب</h2>
                <div class="form-group">
                    <label for="edit-title">عنوان الواجب</label>
                    <input type="text" id="edit-title" required>
                </div>
                <div class="form-group">
                    <label for="edit-class">الصف</label>
                    <input type="text" id="edit-class" disabled>
                </div>
                <div class="form-group">
                    <label for="edit-due-date">تاريخ التسليم</label>
                    <input type="date" id="edit-due-date" required>
                </div>
                <div class="form-group">
                    <label>المرفقات الحالية</label>
                    <ul class="file-list" id="edit-attachments-list">
                    </ul>
                </div>
                <div class="form-group">
                    <label for="add-new-file">إضافة ملفات جديدة</label>
                    <input type="file" id="add-new-file" multiple>
                </div>
                <div class="edit-actions">
                    <button class="modal-btn cancel" id="cancel-edit-btn">إلغاء</button>
                    <button class="modal-btn save" id="save-edit-btn">حفظ</button>
                </div>
            </section>

            <section class="submissions-section">
                <h2>قائمة الطلاب المسلمين</h2>
                <table class="submissions-table">
                    <thead>
                        <tr>
                            <th>اسم الطالب</th>
                            <th>تاريخ التسليم</th>
                            <th>التقييم (من 10)</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="submissions-table-body">

                    </tbody>
                </table>
            </section>

            <button class="edit-assignment-btn" id="edit-assignment-btn-trigger">
                <i class="fas fa-edit"></i>
                <span>تعديل الواجب</span>
            </button>
        </main>
    </div>


    <div id="message-box" class="message-box"></div>

    <script src="{{ asset('assets/js/homework-details.js') }}"></script>
</body>
</html>--}}
{{-- resources/views/homework-detials.blade.php --}}
{{-- resources/views/assignments-show.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>تفاصيل الواجب</title>

  <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">

  <style>
    :root{
      --primary:#2a67f3; --ink:#0f2f72; --muted:#6b7280; --bg:#f3f9ff; --card:#fff;
      --border:#d7e2ff; --danger:#b91c1c; --soft:#f0f6ff;
    }
    *{box-sizing:border-box} body{font-family:'Cairo',sans-serif;background:var(--bg);margin:0}
    .page{max-width:1100px;margin:0 auto;padding:24px}
    .topbar{display:flex;gap:10px;align-items:center;margin-bottom:12px}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:.7rem 1.1rem;border-radius:12px;
      font-weight:800;text-decoration:none;border:1px solid transparent;cursor:pointer;transition:.15s ease}
    .btn-primary{background:var(--primary);color:#fff}
    .btn-primary:hover{filter:brightness(0.95);transform:translateY(-1px)}
    .btn-secondary{background:#fff;color:var(--ink);border-color:var(--border)}
    .btn-secondary:hover{background:#f8fbff}
    .btn-danger{background:#fff;color:var(--danger);border-color:#f3c2c4}
    .btn-danger:hover{background:#fff5f5}
    .header{display:flex;align-items:center;justify-content:space-between;margin:10px 0 18px}
    .header h1{margin:0;color:#193b8a;font-weight:900}

    .card{background:var(--card);border:1px solid var(--border);border-radius:16px;box-shadow:0 6px 30px rgba(28,61,140,.06);padding:20px}
    .grid{display:grid;grid-template-columns:1.4fr .8fr;gap:22px}
    .section-title{margin:0 0 10px;font-weight:900;color:var(--ink)}
    .meta{width:100%}
    .meta-row{display:grid;grid-template-columns:160px 1fr;gap:10px;padding:10px 0;border-bottom:1px dashed var(--border)}
    .meta-row:last-child{border-bottom:none}
    .meta-key{color:var(--muted);font-weight:800}
    .meta-val{color:#111;font-weight:800}
    .muted{color:var(--muted)}
    .desc{background:var(--soft);border:1px solid var(--border);border-radius:12px;padding:12px}
    .attachments{display:flex;flex-direction:column;gap:10px}
    .att{display:flex;justify-content:space-between;align-items:center;gap:10px;background:var(--soft);
         border:1px solid var(--border);border-radius:12px;padding:.65rem .8rem}
    .att a{text-decoration:none;color:#1d4ed8;font-weight:800;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .pill{display:inline-flex;align-items:center;gap:6px;padding:.35rem .7rem;border-radius:999px;font-weight:800;font-size:.85rem}
    .pill-blue{background:rgba(37,99,235,.12);color:#2563eb}
    .pill-red{background:rgba(185,28,28,.12);color:#b91c1c}
    .numbers{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
    .kpi{background:#fff;border:1px solid var(--border);border-radius:12px;padding:.4rem .7rem;font-weight:800}
    @media (max-width:900px){ .grid{grid-template-columns:1fr} }
  </style>
</head>
<body>
<div class="page">

  <div class="topbar">
    <a class="btn btn-secondary" href="{{ route('assignments.index') }}"><i class="fa fa-arrow-right"></i> الرجوع للقائمة</a>
    <a class="btn btn-primary" href="{{ route('assignments.edit',$assignment->id) }}"><i class="fa fa-pen"></i> تعديل</a>


  </div>

  <div class="header">
    <h1>تفاصيل الواجب</h1>
    @php
      $status = $assignment->status_label ?? null;
      $statusClass = ($status === 'منتهي') ? 'pill pill-red' : 'pill pill-blue';
    @endphp
    @if($status)
      <span class="{{ $statusClass }}"><i class="fa fa-circle"></i> {{ $status }}</span>
    @endif
  </div>

  @if(session('success'))
    <div class="card" style="margin-bottom:14px"><span class="muted"><i class="fa fa-check-circle"></i> {{ session('success') }}</span></div>
  @endif

  <div class="card grid">
    <div>
      <h3 class="section-title">البيانات الأساسية</h3>
      <div class="meta">
        <div class="meta-row">
          <div class="meta-key">اسم الواجب</div>
          <div class="meta-val">{{ $assignment->title }}</div>
        </div>

        <div class="meta-row">
          <div class="meta-key">الصف</div>
          <div class="meta-val">الصف {{ $assignment->lesson->grade ?? '—' }}</div>
        </div>

        <div class="meta-row">
          <div class="meta-key">تاريخ النشر</div>
          <div class="meta-val">{{ optional($assignment->created_at)->format('Y-m-d H:i') ?? '—' }}</div>
        </div>

        <div class="meta-row">
          <div class="meta-key">تاريخ التسليم</div>
          <div class="meta-val">{{ optional($assignment->due_at)->format('Y-m-d H:i') ?? '—' }}</div>
        </div>

<div class="meta-row">
  <div class="meta-key">الدرجة القصوى</div>
  <div class="meta-val">{{ is_null($assignment->weight) ? '—' : $assignment->weight }}</div>
</div>


        <div class="meta-row">
          <div class="meta-key">عدد الطلاب المسلّمين</div>
          <div class="meta-val">
            @php
              $submitted = $assignment->submissions_count ?? $assignment->submissions()->count();
            @endphp
            <div class="numbers">
              <span class="kpi">{{ $submitted }}</span>
            </div>
          </div>
        </div>
      </div>

      @if(!empty($assignment->body))
        <h3 class="section-title" style="margin-top:16px">وصف الواجب</h3>
        <div class="desc">{!! nl2br(e($assignment->body)) !!}</div>
      @endif

      <h3 class="section-title" style="margin-top:16px">المرفقات</h3>
      @if($assignment->attachments->isEmpty())
        <div class="muted">لا توجد مرفقات.</div>
      @else
        <div class="attachments">
          @foreach($assignment->attachments as $att)
            <div class="att">
              <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($att->path) }}" target="_blank" rel="noopener">
                <i class="fa fa-paperclip"></i>
                {{ $att->original_name }}
              </a>
              <span class="muted">{{ number_format(($att->size ?? 0)/1024, 0) }} KB</span>
            </div>
          @endforeach
        </div>
      @endif
    </div>

    <div>
      <h3 class="section-title">ملخّص سريع</h3>
      <div class="desc" style="display:flex;flex-direction:column;gap:8px">
        <div><span class="muted">الحالة:</span>
          <strong>{{ $status ?? '—' }}</strong>
        </div>
        <div><span class="muted">التسليم:</span>
          <strong>{{ optional($assignment->due_at)->diffForHumans() ?? '—' }}</strong>
        </div>
        <div><span class="muted">أُضيف في:</span>
          <strong>{{ optional($assignment->created_at)->diffForHumans() ?? '—' }}</strong>
        </div>
        <div><span class="muted">الدرجة القصوى:</span>
  <strong>{{ is_null($assignment->weight) ? '—' : $assignment->weight }}</strong>
</div>
        <div><span class="muted">الصف:</span>
          <strong>{{ $assignment->lesson->grade ?? '—' }}</strong>
        </div>
      </div>
    </div>
  </div>

</div>
</body>
</html>


