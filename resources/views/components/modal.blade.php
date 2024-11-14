@props(['title' => 'Form', 'size' => 'lg', 'action' => null, 'method' => 'POST', 'id' => 'formAction'])
                            <div class="modal-dialog modal-{{ $size }}">
                                @if ($action)
                                    <form id="{{ $id }}" action="{{ $action }}" method="{{ $method }}" >
                                @csrf
                                @endif
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $slot }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        @if ($action)
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        @endif
                                    </div>
                                </div>
                                @if ($action)
                                    </form>
                                @endif
                            </div>
