<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>الدعم الفني</title>

  <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/homeworks-dashboard.css') }}"><!-- نعيد استخدام نفس ستايلك العام -->

  <style>
    :root{
      --brand:#3b82f6; --brand-600:#2563eb; --brand-700:#1e40af;
      --ink:#0f172a; --muted:#475569; --card:#fff; --line:#e5e7eb;
    }
    body{ font-family:"Cairo",sans-serif; background:#f0f2f5; }

    .page-container{ min-height:100vh; }

    .main-content{ max-width:1100px; margin:100px auto 40px; padding:0 16px; }

    .page-header{
      display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:18px;
    }
    .page-header h1{ margin:0; font-weight:800; color:#1e293b; }

    /* بطاقة */
    .card{
      background:var(--card); border-radius:14px; box-shadow:0 10px 30px rgba(2,6,23,.08);
      padding:20px; margin-bottom:18px;
    }

    /* فورم إنشاء رسالة */
    .support-form .grid{ display:grid; grid-template-columns:1fr; gap:12px; }
    .support-form label{ font-weight:800; color:#2d3a4a; margin-bottom:6px; display:block; }
    .support-form input[type="text"], .support-form textarea, .support-form select{
      width:100%; border:1px solid #dbe1ea; border-radius:10px; padding:12px 14px; background:#f8fbff;
      font-size:16px; outline:none; transition:box-shadow .2s, border-color .2s;
    }
    .support-form textarea{ min-height:130px; resize:vertical; }
    .support-form input:focus, .support-form textarea:focus, .support-form select:focus{
      border-color:var(--brand-600); box-shadow:0 0 0 3px rgba(37,99,235,.15);
    }
    .btn-primary{
      display:inline-flex; align-items:center; justify-content:center; gap:8px;
      background:linear-gradient(90deg, var(--brand) 0%, var(--brand-600) 100%);
      color:#fff; padding:12px 16px; border:0; border-radius:10px; font-weight:800; cursor:pointer;
      box-shadow:0 8px 16px rgba(59,130,246,.25); transition:filter .15s, transform .06s, box-shadow .2s;
    }
    .btn-primary:hover{ filter:brightness(1.02); box-shadow:0 10px 18px rgba(59,130,246,.28); }
    .btn-primary:active{ transform:translateY(1px); }

    /* جدول الرسائل */
    .support-table{ width:100%; border-collapse:separate; border-spacing:0; overflow:hidden; }
    .support-table th, .support-table td{
      padding:12px 12px; text-align:right; border-bottom:1px solid var(--line);
      vertical-align:top;
    }
    .support-table thead th{
      background:#f8fafc; color:#0f172a; font-weight:800; position:sticky; top:0; z-index:1;
    }
    .subject{ font-weight:800; color:#0f172a; }
    .message-text{ color:#334155; white-space:pre-wrap; }

    .badge{
      padding:.35rem .7rem; border-radius:999px; font-weight:800; font-size:.85rem; display:inline-block;
    }
    .st-open{ background:rgba(59,130,246,.12); color:#2563eb; }
    .st-answered{ background:rgba(16,185,129,.12); color:#059669; }
    .st-closed{ background:rgba(185,28,28,.12); color:#b91c1c; }

    .actions{ display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
    .btn-light{
      background:#fff; color:#1e293b; border:1px solid #e5e7eb; padding:8px 12px; border-radius:10px;
      font-weight:800; cursor:pointer; transition:background .15s, transform .06s;
    }
    .btn-light:hover{ background:#f8fafc; }
    .btn-danger{
      background:#fff; color:#b91c1c; border:1px solid #f3c2c4; padding:8px 12px; border-radius:10px;
      font-weight:800; cursor:pointer;
    }

    /* فورم الرد داخل الجدول */
    .reply-form{
      display:grid; grid-template-columns:1fr 170px 120px; gap:8px; margin-top:8px;
    }
    .reply-form textarea{
      min-height:90px; padding:10px 12px; border:1px solid #dbe1ea; border-radius:10px; background:#fff;
    }
    .reply-form select{
      border:1px solid #dbe1ea; border-radius:10px; padding:10px 12px; background:#fff;
    }

    @media (max-width: 768px){
      .reply-form{ grid-template-columns:1fr; }
    }

    .alert{
      border-radius:10px; padding:10px 12px; margin:10px 0 0; font-weight:700;
    }
    .alert-success{ background:#e8f6ff; color:#0a5ea8; border:1px solid #cfeaff; }
    .alert-danger{ background:#ffe5e5; color:#8a1f1f; border:1px solid #f7caca; }
  </style>
</head>
<body>
  <div class="page-container">
    {{-- نافبارك الحالية --}}
    <nav>
      <div class="nav-left">
        <a class="brand" href="{{ route('home') }}">
          <img class="logo" src="{{ asset('assets/images/imageedit_2_6635233653.png') }}" alt="شعار المنصة" />
          <img class="brand-name" src="{{ asset('assets/images/logomwhite.png') }}" alt="Grow" />
        </a>
      </div>

      <div class="nav-menu">
        <a href="{{ route('home') }}" class="nav-link">
          <i class="fas fa-home" style="margin-left:8px;"></i> الصفحة الرئيسية
        </a>
      </div>

      <div class="nav-right">
        <button class="nav-btn" title="الإشعارات"><i class="fas fa-bell"></i><span class="badge">3</span></button>
        <a href="#" class="nav-btn" title="الإعدادات"><i class="fas fa-cog"></i></a>
        <a href="#" class="logout-btn"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i><span>تسجيل خروج</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
      </div>
    </nav>

    <main class="main-content">
      <section class="page-header">
        <h1>الدعم الفني</h1>
      </section>

      {{-- رسائل النظام --}}
      @if (session('status'))
        <div class="card alert alert-success">{{ session('status') }}</div>
      @endif
      @if ($errors->any())
        <div class="card alert alert-danger">
          <ul style="margin:0; padding-inline-start:18px;">
            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
        </div>
      @endif

      {{-- فورم إنشاء رسالة دعم جديدة --}}
      <section class="card support-form">
        <h2 style="margin:0 0 10px; font-weight:800; color:#1f2937;">إرسال رسالة دعم</h2>
        <form method="POST" action="{{ route('support.store') }}" class="grid">
          @csrf
          <div>
            <label for="subject">الموضوع (اختياري)</label>
            <input id="subject" type="text" name="subject" value="{{ old('subject') }}">
          </div>

          <div>
            <label for="message">نص الرسالة</label>
            <textarea id="message" name="message" required>{{ old('message') }}</textarea>
          </div>

          <div style="text-align:left">
            <button type="submit" class="btn-primary">
              <i class="fa fa-paper-plane" style="margin-left:6px"></i> إرسال الرسالة
            </button>
          </div>
        </form>
      </section>

      {{-- جدول الرسائل --}}
      <section class="card">
        <h2 style="margin:0 0 12px; font-weight:800; color:#1f2937;">الرسائل الواردة</h2>

        <table class="support-table">
          <thead>
            <tr>
              <th style="width:160px;">المرسل</th>
              <th>الموضوع / الرسالة</th>
              <th style="width:140px;">الحالة</th>
              <th style="width:250px;">إجراءات</th>
            </tr>
          </thead>
          <tbody>
            @forelse($messages as $msg)
              <tr>
                <td>
                  <div class="subject">{{ $msg->creator->name ?? '—' }}</div>
                  <div style="color:#64748b; font-size:.9rem">{{ $msg->created_at->format('Y-m-d H:i') }}</div>
                </td>

                <td>
                  <div class="subject">{{ $msg->subject ?: 'بدون موضوع' }}</div>
                  <div class="message-text">{{ $msg->message }}</div>

                  @if($msg->response)
                    <div style="margin-top:10px; padding:10px; background:#f8fafc; border:1px solid #e5e7eb; border-radius:10px;">
                      <strong style="color:#0f172a;">رد:</strong>
                      <div class="message-text">{{ $msg->response }}</div>
                    </div>
                  @endif
                </td>

                <td>
                  @php
                    $st = $msg->status;
                    $cls = $st === 'open' ? 'st-open' : ($st === 'answered' ? 'st-answered' : 'st-closed');
                  @endphp
                  <span class="badge {{ $cls }}">
                    {{ $st === 'open' ? 'مفتوحة' : ($st === 'answered' ? 'تم الرد' : 'مغلقة') }}
                  </span>
                </td>

                <td>
                  {{-- فورم الرد السريع --}}
                  <form method="POST" action="{{ route('support.reply', $msg) }}" class="reply-form">
                    @csrf
                    <textarea name="response" placeholder="اكتب الرد هنا..."></textarea>
                    <select name="status">
                      <option value="answered" @selected($msg->status==='answered')>تم الرد</option>
                      <option value="open" @selected($msg->status==='open')>إبقاءها مفتوحة</option>
                      <option value="closed" @selected($msg->status==='closed')>إغلاق</option>
                    </select>
                    <button type="submit" class="btn-primary">حفظ الرد</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" style="text-align:center; color:#64748b;">لا توجد رسائل حتى الآن</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>
