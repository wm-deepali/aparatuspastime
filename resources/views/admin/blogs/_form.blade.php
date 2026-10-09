@php
    use Illuminate\Support\Str;

    $blog = $blog ?? null;
    $isEdit = (bool) $blog;

    // old() first (after validation error), then the saved value, then default
    $val = fn($k, $d = '') => old($k, $blog->{$k} ?? $d);
    $chk = fn($k, $d = 0) => request()->old() ? (bool) old($k) : (bool) ($blog->{$k} ?? $d);

    $takeaways = old('key_takeaways', $isEdit ? implode("\n", $blog->key_takeaways ?? []) : '');
    $tagsText  = old('tags', $isEdit ? implode(', ', $blog->tags ?? []) : '');
    $selectedProducts = collect(old('recommended_product_ids', $blog->recommended_product_ids ?? []))->map(fn($i) => (int) $i)->all();

    $publishedAt = old('published_at', $isEdit
        ? optional($blog->published_at)->format('Y-m-d\TH:i')
        : now()->format('Y-m-d\TH:i'));

    $imgUrl = fn($p) => blank($p) ? null
        : (Str::startsWith($p, ['http://', 'https://']) ? $p
        : (Str::startsWith($p, ['assets/', 'images/']) ? asset($p) : asset('storage/' . $p)));

    $imageFields = [
        'image'         => ['Featured Image (card thumbnail)', 'PNG, JPG, WEBP · 800×500px'],
        'banner_image'  => ['Banner Image (article top)', 'Optional · 1400×790px · falls back to Featured Image'],
    ];
@endphp

<div class="create-layout">

    <!-- ── LEFT column ── -->
    <div>

        <!-- Basic Info -->
        <div class="section-card">
            <div class="section-card-header"><h5>Basic Info</h5></div>
            <div class="section-card-body">

                <div class="field-group">
                    <label class="field-label">Title <span class="req">*</span></label>
                    <input type="text" name="title" id="title" class="field-input" value="{{ $val('title') }}" required>
                    @error('title')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-group">
                    <label class="field-label">Slug</label>
                    <div class="slug-wrap">
                        <span class="slug-prefix">blog-detail/</span>
                        <input type="text" name="slug" id="slug" class="field-input" value="{{ $val('slug') }}">
                    </div>
                    <div class="field-hint">Auto-generated from title. You can edit manually.</div>
                    @error('slug')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">Category</label>
                        <input type="text" name="category" class="field-input" list="categoryList"
                               value="{{ $val('category') }}" placeholder="e.g. Games & Play">
                        <datalist id="categoryList">
                            @foreach ($categories as $c)
                                <option value="{{ $c }}">
                            @endforeach
                        </datalist>
                        <div class="field-hint">Pick an existing one or type a new one.</div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Read Time (minutes)</label>
                        <input type="number" name="read_time" class="field-input" min="1" max="999"
                               value="{{ $val('read_time') }}" placeholder="Auto">
                        <div class="field-hint">Leave empty to calculate from the content.</div>
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label">Short Description</label>
                    <textarea name="short_description" class="field-textarea" rows="3"
                              placeholder="A brief summary shown on blog listing…">{{ $val('short_description') }}</textarea>
                </div>

            </div>
        </div>

        <!-- Content -->
        <div class="section-card">
            <div class="section-card-header"><h5>Content <span style="color:var(--red);font-size:12px">*</span></h5></div>
            <div class="section-card-body">
                <div class="field-group">
                    <textarea name="content" class="field-textarea" rows="14" style="min-height:320px" required
                              placeholder="Write your blog content here… (HTML allowed)">{{ $val('content') }}</textarea>
                    <div class="field-hint">HTML is rendered as-is on the article page.</div>
                    @error('content')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <!-- Key takeaways & tags -->
        <div class="section-card">
            <div class="section-card-header"><h5>Takeaways & Tags</h5></div>
            <div class="section-card-body">

                <div class="field-group">
                    <label class="field-label">Key Takeaways</label>
                    <textarea name="key_takeaways" class="field-textarea" rows="5"
                              placeholder="One takeaway per line">{{ $takeaways }}</textarea>
                    <div class="field-hint">One per line. The box is hidden on the article if empty.</div>
                </div>

                <div class="field-group">
                    <label class="field-label">Tags</label>
                    <input type="text" name="tags" class="field-input" value="{{ $tagsText }}"
                           placeholder="OutdoorPlay, ScreenFree, FamilyTime">
                    <div class="field-hint">Comma separated.</div>
                </div>

            </div>
        </div>

        <!-- Author -->
        <div class="section-card">
            <div class="section-card-header"><h5>Author</h5></div>
            <div class="section-card-body">

                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">Name</label>
                        <input type="text" name="author_name" class="field-input" value="{{ $val('author_name') }}">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Role</label>
                        <input type="text" name="author_role" class="field-input" value="{{ $val('author_role') }}"
                               placeholder="Child Development & Play Specialist">
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label">Bio</label>
                    <textarea name="author_bio" class="field-textarea" rows="3">{{ $val('author_bio') }}</textarea>
                </div>

                <div class="field-group">
                    <label class="field-label">Avatar</label>
                    @if ($isEdit && $imgUrl($blog->author_avatar))
                        <div class="img-current-label">Current Avatar</div>
                        <img src="{{ $imgUrl($blog->author_avatar) }}" class="img-current" style="max-width:90px;height:90px" data-current alt="">
                    @endif
                    <div class="upload-area">
                        <input type="file" name="author_avatar" accept="image/*" class="img-input">
                        <div class="upload-icon"><i class="fa fa-user-circle"></i></div>
                        <div class="upload-label">{{ $isEdit && $blog->author_avatar ? 'Replace avatar' : 'Upload avatar' }}</div>
                        <div class="upload-sub">Square · 200×200px</div>
                    </div>
                    <div class="new-preview"><img src="" alt=""><span></span></div>
                </div>

            </div>
        </div>

    </div>

    <!-- ── RIGHT column ── -->
    <div>

        <!-- Images -->
        @foreach ($imageFields as $field => [$label, $sub])
            <div class="section-card">
                <div class="section-card-header"><h5>{{ $label }}</h5></div>
                <div class="section-card-body">

                    @if ($isEdit && $imgUrl($blog->{$field}))
                        <div class="img-current-label">Current Image</div>
                        <img src="{{ $imgUrl($blog->{$field}) }}" class="img-current" data-current alt="">
                    @endif

                    <div class="upload-area">
                        <input type="file" name="{{ $field }}" accept="image/*" class="img-input">
                        <div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>
                        <div class="upload-label">{{ $isEdit && $blog->{$field} ? 'Replace image' : 'Click to upload image' }}</div>
                        <div class="upload-sub">{{ $sub }}</div>
                    </div>
                    <div class="new-preview"><img src="" alt=""><span></span></div>
                    @error($field)<div class="field-error">{{ $message }}</div>@enderror

                </div>
            </div>
        @endforeach

        <!-- Products -->
        <div class="section-card">
            <div class="section-card-header"><h5>Toys In This Article</h5></div>
            <div class="section-card-body">
                <select name="recommended_product_ids[]" class="field-select" multiple size="7">
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}" {{ in_array($p->id, $selectedProducts) ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
                <div class="field-hint">Ctrl / Cmd + click for multiple (the first 3 are shown). Hidden if none selected.</div>
            </div>
        </div>

        <!-- Publishing -->
        <div class="section-card">
            <div class="section-card-header"><h5>Publishing</h5></div>
            <div class="section-card-body">
                <div class="field-group">
                    <label class="field-label">Publish Date</label>
                    <input type="datetime-local" name="published_at" class="field-input" value="{{ $publishedAt }}">
                    <div class="field-hint">A future date keeps it hidden until then.</div>
                </div>
            </div>
        </div>

        <!-- SEO -->
        <div class="section-card">
            <div class="section-card-header"><h5>SEO Settings</h5></div>
            <div class="section-card-body">
                <div class="field-group">
                    <label class="field-label">Meta Title</label>
                    <input type="text" name="meta_title" class="field-input" value="{{ $val('meta_title') }}"
                           placeholder="Defaults to the blog title">
                </div>
                <div class="field-group">
                    <label class="field-label">Meta Description</label>
                    <textarea name="meta_description" class="field-textarea" rows="4"
                              placeholder="Defaults to the short description">{{ $val('meta_description') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="section-card">
            <div class="section-card-header"><h5>Settings</h5></div>
            <div class="section-card-body" style="padding:16px 20px">

                <div class="toggle-row">
                    <div>
                        <div class="toggle-label">Status</div>
                        <div class="toggle-sub">Publish this blog post</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="status" {{ $chk('status', 1) ? 'checked' : '' }}>
                        <span class="toggle-track"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div>
                        <div class="toggle-label">Show on Home Page</div>
                        <div class="toggle-sub">Feature on the storefront homepage</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="show_home" {{ $chk('show_home') ? 'checked' : '' }}>
                        <span class="toggle-track"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div>
                        <div class="toggle-label">Featured Story</div>
                        <div class="toggle-sub">Big banner on the blog page (only one)</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="is_featured" {{ $chk('is_featured') ? 'checked' : '' }}>
                        <span class="toggle-track"></span>
                    </label>
                </div>

            </div>
        </div>

    </div>
</div>